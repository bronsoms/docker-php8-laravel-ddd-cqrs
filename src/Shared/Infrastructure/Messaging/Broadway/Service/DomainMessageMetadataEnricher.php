<?php

namespace Shared\Infrastructure\Messaging\Broadway\Service;

use Broadway\EventSourcing\MetadataEnrichment\MetadataEnricher;
use Shared\Domain\Model\User\User;
use Illuminate\Auth\AuthManager;
use Broadway\Domain\Metadata;

class DomainMessageMetadataEnricher implements MetadataEnricher
{
    public const DEFAULT_AUTHOR = 'System';

    /** @var AuthManager */
    private $authManager;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    public function enrich(Metadata $metadata): Metadata
    {
        return $metadata->merge($metadata->kv('author_id', $this->getCurrentUser()));
    }

    private function getCurrentUser(): string
    {
        /** @var User $user */
        $user = $this->authManager->guard()->user();

        return $user ? $user->getAggregateRootId() : self::DEFAULT_AUTHOR;
    }
}
