<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class OrderProductRequest extends Base implements IRequest
{
    private string $ean;
    private float $quantity = 1;
    private float $price = 0;

    public function setEan(string $ean): void
    {
        $this->ean = $ean;
    }

    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
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

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'ean' => $this->ean,
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }
}