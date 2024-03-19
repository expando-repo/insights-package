<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class OrderProductRequest extends Base implements IRequest
{
    private string $ean;
    private float $quantity;
    private ?int $productId = null;

    public function __construct(?int $productId, int $ean, float $quantity = null)
    {
        $this->productId = $productId;
        $this->ean = $ean;
        $this->quantity = $quantity;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getEan(): string
    {
        return $this->ean;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'ean' => $this->ean,
            'product_id' => $this->productId,
            'quantity' => $this->quantity,
        ];
    }
}