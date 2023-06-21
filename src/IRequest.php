<?php

declare(strict_types=1);

namespace Expando\InsightsPackage;

interface IRequest
{
    public function asArray(): array;
}