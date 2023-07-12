<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

use CURLFile;
use Expando\InsightsPackage\IRequest;

class FeedRequest extends Base implements IRequest
{
    private ?string $source = null;
    private ?CURLFile $feed = null;

    public function __construct(?string $source = null, string $feed = null)
    {
        $this->source = $source;
        $this->feed = new CURLFile($feed, '.xml', 'file');
    }

    /**
     * @return CURLFile|null
     */
    public function getFeed(): ?CURLFile
    {
        return $this->feed;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'file' => $this->feed
        ];

    }
}