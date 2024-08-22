<?php

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class ProductToRegister extends Base implements IRequest
{
    private string $url = "";
    private string $product_id = "";
    private ?string $shop_product_id = "";

    /**
     * @param string $product_id Required ID of product
     * @param string $url Required URL of product
     * @param ?string $shop_product_id identifer of product in shop
     */
    public function __construct(string $product_id, string $url, ?string $shop_product_id)
    {
        $this->product_id = $product_id;
        $this->url = $url;
        $this->shop_product_id = $shop_product_id;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setProductId(string $product_id): void
    {
        $this->product_id = $product_id;
    }
    
    public function getProductId(): string
    {
        return $this->product_id;
    }
    
    public function setShopProductId(?string $shop_product_id): void
    {
        $this->shop_product_id = $shop_product_id;
    }
    
    public function getShopProductId(): string
    {
        return $this->shop_product_id;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'url' => $this->url,
            'product_id' => $this->product_id,
            'shop_product_id' => $this->shop_product_id,
        ];
    }
}
