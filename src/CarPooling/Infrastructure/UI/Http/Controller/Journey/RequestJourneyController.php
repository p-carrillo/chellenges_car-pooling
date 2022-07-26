<?php

declare(strict_types=1);

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Journey;

use App\CarPooling\Application\Command\Journey\RequestJourney\RequestJourneyCommand;
use Doctrine\DBAL\Types\Types;
use JsonException;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TypeError;

class RequestJourneyController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $input = $this->RetrieveReeuestValidatedOrFail($request);

            $this->commandBus->handle(new RequestJourneyCommand(
                $input['id'],
                $input['people']
            ));

            return new Response(
                 null,
                Response::HTTP_OK
            );
        } catch (BadRequestException | JsonException) {
            return new Response(
                null,
                Response::HTTP_BAD_REQUEST
            );
        } catch (TypeError) {
            return new Response(
                null,
                Response::HTTP_UNSUPPORTED_MEDIA_TYPE
            );
        }
    }

    private function RetrieveReeuestValidatedOrFail(Request $request) :array
    {
        if ($request->getContentType() !== Types::JSON) {
            throw new TypeError();
        }

        $journeyRequest = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if ( !isset($journeyRequest['id']) || !isset($journeyRequest['people']))  {
            Throw new TypeError();
        }

        return $journeyRequest;
    }
}
