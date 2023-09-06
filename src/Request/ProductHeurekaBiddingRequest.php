<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class ProductHeurekaBiddingRequest extends Base implements IRequest
{
    private ?int $ean = null;
    private ?string $language = null;

    public function __construct(?int $ean = null, string $language = 'cz')
    {
        $this->ean = $ean;
        $this->language = $language;
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
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'ean' => $this->ean,
            'language' => $this->language,
        ];
    }
}