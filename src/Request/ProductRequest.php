<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class ProductRequest extends Base implements IRequest
{
    private ?int $productId = null;

    public function __construct(?int $productId = null)
    {
        $this->productId = $productId;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'product_id' => $this->productId,
        ];
    }
}