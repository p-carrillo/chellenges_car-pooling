<?php

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Status;

use Symfony\Component\HttpFoundation\Response;

class StatusController
{
    public function __invoke(): Response
    {
        return new Response(
            null,
            Response::HTTP_OK
        );
    }
}