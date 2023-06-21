<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Response\Product;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;

class PostResponse implements IResponse
{
    private int $product_id;

    /**
     * PostResponse constructor.
     * @param array $data
     * @throws InsightsException
     */
    public function __construct(array $data)
    {
        if (($data['product_id'] ?? null) === null) {
            throw new InsightsException('Response not return product_id');
        }
        $this->product_id = $data['product_id'];
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }
}