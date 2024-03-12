<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class ProductRulesIframeRequest extends Base implements IRequest
{
    private ?int $ean = null;
    private ?string $source = null;

    public function __construct(?int $ean = null, string $source = 'Heureka CZ')
    {
        $this->ean = $ean;
        $this->source = $source;
    }

    /**
     * @return int|null
     */
    public function getEan(): ?int
    {
        return $this->ean;
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
            'ean' => $this->ean,
            'source' => $this->source,
        ];
    }
}