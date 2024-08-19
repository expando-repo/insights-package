<?php

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class RegisterProductsRequest extends Base implements IRequest
{
    private array $products = [];

    /**
     * @param ProductToRegister $ProductToRegister
     * @return void
     */
    public function addProductToRegister(ProductToRegister $ProductToRegister): void
    {
        $this->products[] = $ProductToRegister->asArray();
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'products' => $this->products,
        ];
    }
}
