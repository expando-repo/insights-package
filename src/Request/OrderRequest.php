<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class OrderRequest extends Base implements IRequest
{
    private string $orderNumber = "";
    private string $currencyCode = "CZK";
    private string $countryCode = "CZ";
    private float $totalPrice = 0;
    private string $createdAt = "";
    private array $orderProducts = [];

    public function __construct(string $orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    public function setOrderNumber(string $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return int
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function setCurrencyCode(string $currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCountryCode(string $countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function getCountryCode() : string
    {
        return $this->countryCode;
    }

    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt() : string
    {
        return $this->createdAt;
    }

    public function setTotalPrice(float $totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    public function getTotalPrice() : float
    {
        return $this->totalPrice;
    }

    /**
     * @param OrderProductRequest $orderProductRequest
     * @return void
     */
    public function addOrderProduct(OrderProductRequest $orderProductRequest): void
    {
        $this->orderProducts[] = $orderProductRequest->asArray();
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'order_number' => $this->orderNumber,
            'line_items' => $this->orderProducts,
            'currency' => $this->currencyCode,
            'country_code' => $this->countryCode,
            'total_price' => $this->totalPrice,
            'created_at' => $this->createdAt,
        ];
    }
}