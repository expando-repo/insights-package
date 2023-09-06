<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class ProductHeurekaBiddingRequest extends Base implements IRequest
{
    private ?int $ean = null;

    public function __construct(?int $ean = null)
    {
        $this->ean = $ean;
    }

    /**
     * @return int|null
     */
    public function getEan(): ?int
    {
        return $this->ean;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'ean' => $this->ean,
        ];
    }
}