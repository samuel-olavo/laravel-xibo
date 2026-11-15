<?php

namespace SamuelOlavo\LaravelXibo\Connections;

use Illuminate\Contracts\Config\Repository;
use InvalidArgumentException;
use SamuelOlavo\LaravelXibo\XiboClient;
use SamuelOlavo\LaravelXibo\Spec\Repository as SpecRepository;
use SamuelOlavo\LaravelXibo\Http\Executor;

final class ConnectionManager
{
    public function __construct(
        private readonly Repository $config,
        private readonly SpecRepository $specifications,
        private readonly Executor $executor,
    ) {}

    public function connection(?string $name = null): XiboClient
    {
        $name ??= (string) $this->config->get('xibo.default', 'default');
        if (! preg_match('/^[A-Za-z0-9_-]+$/', $name)) {
            throw new InvalidArgumentException('Invalid Xibo connection name.');
        }

        $settings = $this->config->get("xibo.connections.{$name}");
        if (! is_array($settings)) {
            throw new InvalidArgumentException("Unknown Xibo connection [{$name}].");
        }

        return new XiboClient(ConnectionConfig::fromArray($name, $settings), $this->specifications, $this->executor);
    }
}
