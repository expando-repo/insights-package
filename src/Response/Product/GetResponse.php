<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Response\Product;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;

class GetResponse implements IResponse
{
    protected int $ean;
    protected string $status;
    protected ?string $message = null;
    protected array $data;
    protected array $productData;

    /**
     * ProductPostResponse constructor.
     * @param array $data
     * @throws InsightsException
     */
    public function __construct(array $data)
    {
        if (($data['ean'] ?? null) === null) {
            throw new InsightsException('Response product not return "ean"');
        }

        if (($data['product_data'] ?? null) === null) {
            throw new InsightsException('Response product not return "product_data"');
        }

        $this->ean = (int) $data['ean'];
        $this->productData = $data['product_data'];
    }

    /**
     * @return int
     */
    public function getProductEan(): int
    {
        return $this->ean;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getProductData(): array
    {
        return $this->productData;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function hasProductData(): bool
    {
        return !empty($this->data);
    }
}