<?php

namespace Expando\InsightsPackage\Response\Product;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;

class RegisterResponse implements IResponse
{
    private string $status;

    /**
     * PostResponse constructor.
     * @param array $data
     * @throws InsightsException
     */
    public function __construct(array $data)
    {
        if (($data['status'] ?? null) === null) {
            throw new InsightsException('Response did not returned status');
        }

        $this->status = $data['status'];
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
