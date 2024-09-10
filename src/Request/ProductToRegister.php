<?php

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class ProductToRegister extends Base implements IRequest
{
    private string $url = "";
    private string $product_id = "";
    private ?string $sourceId = null;
    private ?string $shop_product_id = null;

    /**
     * @param string $product_id Required ID of product
     * @param string $url Required URL of product
     * @param ?string $shop_product_id identifer of product in shop
     */
    public function __construct(string $product_id, string $url, ?string $sourceId, ?string $shop_product_id)
    {
        $this->product_id = $product_id;
        $this->url = $url;
        $this->shop_product_id = $shop_product_id;
        $this->sourceId = $sourceId;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $product_id
     */
    public function setProductId(string $product_id): void
    {
        $this->product_id = $product_id;
    }
    
    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->product_id;
    }
    
    /**
     * @param ?string $shop_product_id
     */
    public function setShopProductId(?string $shop_product_id): void
    {
        $this->shop_product_id = $shop_product_id;
    }
    
    /**
     * @return ?string
     */
    public function getShopProductId(): ?string
    {
        return $this->shop_product_id;
    }

    /**
     * @param ?string $sourceId
     */
    public function setSourceId(?string $sourceId): void
    {
        $this->sourceId = $sourceId;
    }

    /**
     * @return ?string
     */
    public function getSourceId(): ?string
    {
        return $this->sourceId;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'url' => $this->url,
            'product_id' => $this->product_id,
            'source_id' => $this->sourceId,
            'shop_product_id' => $this->shop_product_id,
        ];
    }
}
