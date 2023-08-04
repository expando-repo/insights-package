<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Response\Product;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;

class PostResponse implements IResponse
{
    private string $status;
    private string $hash;

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

        if (($data['hash'] ?? null) === null) {
            throw new InsightsException('Response did not returned hash');
        }
        $this->status = $data['status'];
        $this->hash = $data['hash'];
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }
}