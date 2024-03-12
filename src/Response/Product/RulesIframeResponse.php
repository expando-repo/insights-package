<?php


declare(strict_types=1);

namespace Expando\InsightsPackage\Response\Product;

use Expando\InsightsPackage\Exceptions\InsightsException;
use Expando\InsightsPackage\IResponse;

class RulesIframeResponse implements IResponse
{
    private string $iframe;

    /**
     * PostResponse constructor.
     * @param array $data
     * @throws InsightsException
     */
    public function __construct(array $data)
    {
        if (($data['iframe'] ?? null) === null) {
            throw new InsightsException('Response did not returned iframe');
        }

        $this->iframe = $data['iframe'];
    }

    /**
     * @return string
     */
    public function getIframe(): string
    {
        return $this->iframe;
    }

}