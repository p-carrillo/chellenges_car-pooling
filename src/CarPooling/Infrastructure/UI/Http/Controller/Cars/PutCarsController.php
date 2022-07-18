<?php

declare(strict_types=1);

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Cars;

use App\Common\Application\CommandBus\CommandBusInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PutCarsController
{
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request)
    {
        try {
            $input = $request->getContent();

//            $this->commandBus->handle(new PutCarsCommand(
//                $input
//            ));

            return new JsonResponse(
                $input,
                JsonResponse::HTTP_OK
            );
        } catch (BadRequestException $exception) {
            return new JsonResponse(
                '',
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}