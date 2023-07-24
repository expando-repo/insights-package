<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Response\Product;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;
use Expando\InsightsPackage\Response\Traits\PaginatorTrait;

class ListResponse implements IResponse
{
    use PaginatorTrait;

    /** @var GetResponse[]  */
    private array $products = [];
    private string $status;

    /**
     * ListResponse constructor.
     * @param array $data
     * @throws InsightsException
     */
    public function __construct(array $data)
    {
        if (($data['products'] ?? null) === null) {
            throw new InsightsException('Response not return products');
        }
        $this->status = $data['status'];
        foreach ($data['products'] as $product) {
            $this->products[] = new GetResponse($product);
        }
        $this->setPaginatorData($data['paginator'] ?? []);
    }

    /**
     * @return GetResponse[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
