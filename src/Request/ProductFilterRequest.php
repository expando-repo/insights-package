<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

class ProductFilterRequest
{
    private ?string $fulltext = null;

    /**
     * @param string|null $fulltext
     */
    public function setFulltext(?string $fulltext): void
    {
        $this->fulltext = $fulltext;
    }

    public function asArray(): array
    {
        return [
            'fulltext' => $this->fulltext,
        ];
    }
}
