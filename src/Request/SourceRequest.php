<?php

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class FeedRequest extends Base implements IRequest
{
    private string $source;
    private string $url;

    public function __construct(?string $source, string $url)
    {
        $this->source = $source;
        $this->url = $url;
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
            'url' => $this->url
        ];

    }
}