<?php

declare(strict_types=1);

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Journey;

use App\CarPooling\Application\Command\Journey\RequestJourney\RequestJourneyCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TypeError;

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

            if ( null === $input ) {
                Throw new BadRequestException();
            }

            $this->validateJourneyRequest($input);

            $this->commandBus->handle(new RequestJourneyCommand(
                $input->id,
                $input->people
            ));

            return new JsonResponse(
                '',
                JsonResponse::HTTP_OK
            );
        } catch (BadRequestException $exception) {
            return new JsonResponse(
                'Bad Request',
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (TypeError $exception) {
            return new JsonResponse(
                'Unsupported Media Type',
                JsonResponse::HTTP_UNSUPPORTED_MEDIA_TYPE
            );
        }
    }

    private function validateJourneyRequest( \stdClass $carRequest) :void
    {
        if ( !isset($carRequest->id) || !isset($carRequest->people))  {
            Throw new TypeError();
        }
    }
}