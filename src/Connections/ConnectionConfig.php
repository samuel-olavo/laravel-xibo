<?php

namespace SamuelOlavo\LaravelXibo\Connections;

use InvalidArgumentException;

final readonly class ConnectionConfig
{
    private function __construct(
        private string $name,
        private string $baseUrl,
        private ?string $declaredVersion,
        private ?string $token,
        private ?string $clientId,
        private ?string $clientSecret,
        private ?string $specificationPath,
    ) {}

    public static function fromArray(string $name, array $settings): self
    {
        $url = rtrim((string) ($settings['url'] ?? ''), '/');

        if (! preg_match('~^https?://[^/]+~i', $url)) {
            throw new InvalidArgumentException("Xibo connection [{$name}] needs a valid HTTP(S) URL.");
        }

        return new self(
            $name,
            $url,
            self::optional($settings['version'] ?? null),
            self::optional($settings['token'] ?? null),
            self::optional($settings['client_id'] ?? null),
            self::optional($settings['client_secret'] ?? null),
            self::optional($settings['specification_path'] ?? null),
        );
    }

    private static function optional(mixed $value): ?string
    {
        return $value === null || $value === '' ? null : (string) $value;
    }

    public function name(): string { return $this->name; }
    public function baseUrl(): string { return $this->baseUrl; }
    public function declaredVersion(): ?string { return $this->declaredVersion; }
    public function token(): ?string { return $this->token; }
    public function clientId(): ?string { return $this->clientId; }
    public function clientSecret(): ?string { return $this->clientSecret; }
    public function specificationPath(): ?string { return $this->specificationPath; }
}
