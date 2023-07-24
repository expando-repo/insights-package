<?php

namespace Expando\InsightsPackage\Response\Source;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;

class ListResponse implements IResponse
{
    /** @var GetResponse[]  */
    private array $sources = [];
    private string $status;

    /**
     * ListResponse constructor.
     * @param array $data
     * @throws InsightsException
     */
    public function __construct(array $data)
    {
        if (($data['sources'] ?? null) === null) {
            throw new InsightsException('Response did not return sources');
        }
        $this->status = $data['status'];
        foreach ($data['sources'] as $locale => $sources) {
            foreach ($sources as $source) {
                $this->sources[$locale][] = new GetResponse($source);
            }
        }
    }

    /**
     * @return GetResponse[]
     */
    public function getSources(): array
    {
        return $this->sources;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
