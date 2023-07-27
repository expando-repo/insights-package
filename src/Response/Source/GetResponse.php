<?php

namespace Expando\InsightsPackage\Response\Source;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;

class GetResponse implements IResponse
{
    protected string $name;

    /**
     * ProductPostResponse constructor.
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