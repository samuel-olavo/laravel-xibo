<?php

declare(strict_types=1);

use SamuelOlavo\LaravelXibo\Spec\Normalizer;

require __DIR__.'/../vendor/autoload.php';

$files = array_slice($argv, 1);
if ($files === []) {
    fwrite(STDERR, "Usage: php bin/generate-resources.php <swagger.json> [more specs...]\n");
    exit(1);
}

$operations = [];
$normalizer = new Normalizer();
foreach ($files as $file) {
    $document = json_decode(file_get_contents($file), true, flags: JSON_THROW_ON_ERROR);
    foreach ($normalizer->normalize($document)->all() as $id => $operation) {
        $operations[$id] = $operation;
    }
}
ksort($operations);

function phpIdentifier(string $raw): string
{
    $parts = preg_split('/[^A-Za-z0-9]+/', $raw, -1, PREG_SPLIT_NO_EMPTY);
    $name = lcfirst(implode('', array_map(ucfirst(...), $parts)));
    return preg_match('/^[A-Za-z_]/', $name) ? $name : 'operation'.ucfirst($name);
}

$groups = [];
$map = [];
$canonicalAccessors = [];
foreach ($operations as $id => $operation) {
    $tag = (string) ($operation->tags[0] ?? 'misc');
    $candidate = phpIdentifier($tag);
    $canonicalAccessors[strtolower($candidate)] ??= $candidate;
    $accessor = $canonicalAccessors[strtolower($candidate)];
    $class = ucfirst($accessor).'Resource';
    $method = phpIdentifier($id);
    if (isset($groups[$accessor][$method])) {
        $method .= substr(hash('sha256', $id), 0, 8);
    }
    $groups[$accessor][$method] = $id;
    $map[$id] = ['class' => $class, 'method' => $method, 'accessor' => $accessor];
}
ksort($groups);

$directory = __DIR__.'/../src/Resources';
$namespace = 'SamuelOlavo\\LaravelXibo\\Resources';
foreach (glob($directory.'/*Resource.php') as $existing) {
    if (basename($existing) !== 'BaseResource.php') {
        unlink($existing);
    }
}
foreach ($groups as $accessor => $methods) {
    ksort($methods);
    $class = ucfirst($accessor).'Resource';
    $source = "<?php\n\nnamespace {$namespace};\n\nuse SamuelOlavo\\LaravelXibo\\Http\\XiboResponse;\n\n/** Generated from Xibo API specifications. */\nfinal class {$class} extends BaseResource\n{\n";
    foreach ($methods as $method => $id) {
        $literal = var_export($id, true);
        $source .= "    public function {$method}(array \$input = []): XiboResponse\n    {\n        return \$this->call({$literal}, \$input);\n    }\n\n";
    }
    $source .= "}\n";
    file_put_contents("{$directory}/{$class}.php", $source);
}

$trait = "<?php\n\nnamespace SamuelOlavo\\LaravelXibo\\Resources;\n\n/** Generated resource accessors. */\ntrait ResourceAccessors\n{\n";
foreach ($groups as $accessor => $_) {
    $class = ucfirst($accessor).'Resource';
    $trait .= "    public function {$accessor}(): {$class}\n    {\n        return new {$class}(\$this);\n    }\n\n";
}
$trait .= "}\n";
file_put_contents("{$directory}/ResourceAccessors.php", $trait);

$source = "<?php\n\nnamespace {$namespace};\n\n/** Generated coverage map for Xibo operations. */\nfinal class OperationMap\n{\n    private const OPERATIONS = [\n";
foreach ($map as $id => $entry) {
    $source .= '        '.var_export($id, true).' => [\'class\' => '.$entry['class'].'::class, \'method\' => '.var_export($entry['method'], true).', \'accessor\' => '.var_export($entry['accessor'], true)."],\n";
}
$source .= "    ];\n\n    public static function for(string \$operationId): ?array\n    {\n        return self::OPERATIONS[\$operationId] ?? null;\n    }\n\n    public static function all(): array\n    {\n        return self::OPERATIONS;\n    }\n}\n";
file_put_contents("{$directory}/OperationMap.php", $source);

fwrite(STDOUT, 'Generated '.count($map).' operation methods in '.count($groups)." resources.\n");
