<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class OrderRequest extends Base implements IRequest
{
    private string $orderSourceName;
    private string $orderNumber;
    private array $orderProducts = [];

    public function __construct(int $orderSourceName, ?int $orderNumber = null)
    {
        $this->orderSourceName = $orderSourceName;
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return int|null
     */
    public function getOrderSourceName(): ?string
    {
        return $this->orderSourceName;
    }

    /**
     * @return int
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
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
            'order_source_name' => $this->productId,
            'order_number' => $this->identifier,
            'line_items' => $this->orderProducts,
        ];
    }
}