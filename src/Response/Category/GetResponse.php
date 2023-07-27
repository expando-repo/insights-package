<?php

namespace Expando\InsightsPackage\Response\Category;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;

class GetResponse implements IResponse
{
    protected string $name;

    /**
     * CategoryGetResponse constructor.
     * @param string $name
     * @throws InsightsException
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}