<?php

declare(strict_types=1);

namespace Expando\InsightsPackage\Request;

use Expando\InsightsPackage\IRequest;

class UserPriceRulesIframeRequest extends Base implements IRequest
{
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
        ];
    }
}