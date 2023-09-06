<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Response\HeurekaBidding;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;

class PostResponse implements IResponse
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