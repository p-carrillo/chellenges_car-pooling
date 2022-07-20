<?php

declare(strict_types=1);

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Car;

use App\CarPooling\Application\Command\Car\SetCarFleet\SetCarFleetCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SetCarFleetController
{

    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request)
    {
        try {
            $input = json_decode($request->getContent());

            $this->commandBus->handle(new SetCarFleetCommand(
                $input
            ));

            die;

            return new JsonResponse(
                json_encode($input),
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