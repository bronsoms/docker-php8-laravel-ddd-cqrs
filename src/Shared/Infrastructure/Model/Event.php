<?php

namespace Shared\Infrastructure\Model;

class Event
{
    public function __construct(
        private string $uuid,
        private int $playhead,
        private array $metadata,
        private array $payload,
        private string $recordedOn,
        private string $type
    ) {
    }

    public static function create(
        string $uuid,
        int $playhead,
        array $metadata,
        array $payload,
        string $recordedOn,
        string $type
    ){
        return new self(
            $uuid,
            $playhead,
            $metadata,
            $payload,
            $recordedOn,
            $type
        );
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function playhead(): int
    {
        return $this->playhead;
    }

    public function metadata(): array
    {
        return $this->metadata;
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function recordedOn(): string
    {
        return $this->recordedOn;
    }

    public function type(): string
    {
        return $this->type;
    }
}
