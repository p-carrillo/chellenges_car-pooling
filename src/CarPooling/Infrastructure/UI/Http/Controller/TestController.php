<?php

namespace App\CarPooling\Infrastructure\UI\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class TestController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse('testing symfony');
    }
}