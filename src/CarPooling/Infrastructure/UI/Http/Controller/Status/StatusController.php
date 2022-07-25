<?php

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Status;

use Symfony\Component\HttpFoundation\JsonResponse;

class StatusController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            'Application is Up',
            JsonResponse::HTTP_OK
        );    }
}