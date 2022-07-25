<?php

declare(strict_types=1);

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Journey;

use App\CarPooling\Application\Command\Journey\RequestJourney\RequestJourneyCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RequestJourneyController
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

            $this->commandBus->handle(new RequestJourneyCommand(
                $input->id,
                $input->people
            ));

            return new JsonResponse(
                'Journey registered',
                JsonResponse::HTTP_OK
            );
        } catch (BadRequestException $exception) {
            return new JsonResponse(
                'Bad Request',
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}