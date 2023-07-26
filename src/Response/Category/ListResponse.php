<?php

namespace Expando\InsightsPackage\Response\Category;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;

class ListResponse implements IResponse
{
    /** @var GetResponse[]  */
    private array $categories = [];
    private string $status;

    /**
     * ListResponse constructor.
     * @param array $data
     * @throws InsightsException
     */
    public function __construct(array $data)
    {
        if (($data['categories'] ?? null) === null) {
            throw new InsightsException('Response did not return categories');
        }
        $this->status = $data['status'];
        foreach ($data['categories'] as $category) {
            $this->categories[] = new GetResponse($category);
        }
    }

    /**
     * @return GetResponse[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}