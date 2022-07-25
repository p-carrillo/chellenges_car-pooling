<?php

declare(strict_types=1);

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Journey;

use App\CarPooling\Application\Command\Journey\RequestDropOff\RequestDropOffCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TypeError;

class RequestDropOffController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request)
    {
        try {
            $journeyId = $request->get('ID');

            if ( null === $journeyId ) {
                Throw new BadRequestException();
            }

            $this->validateJourneyIdRequest($journeyId);

            $this->commandBus->handle(new RequestDropOffCommand(
                (int)$journeyId,
            ));

            return new Response(
                null,
                Response::HTTP_NO_CONTENT
            );
        } catch (NotFoundHttpException $exception) {
            return new Response(
                null,
                Response::HTTP_NOT_FOUND
            );
        } catch (BadRequestException $exception) {
            return new Response(
                null,
                Response::HTTP_BAD_REQUEST
            );
        } catch (TypeError $exception) {
            return new Response(
                null,
                Response::HTTP_UNSUPPORTED_MEDIA_TYPE
            );
        }
    }

    private function validateJourneyIdRequest( string $journeyIdRequest) :void
    {
        if (!is_numeric($journeyIdRequest))  {
            Throw new TypeError();
        }
    }
}