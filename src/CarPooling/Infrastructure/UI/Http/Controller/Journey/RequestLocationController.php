<?php

declare(strict_types=1);

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Journey;

use App\CarPooling\Application\Command\Journey\RequestLocation\RequestLocationCommand;
use App\CarPooling\Domain\Model\Car\CarView;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TypeError;

class RequestLocationController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        try {
            $journeyId = $request->get('ID');

            if ( null === $journeyId ) {
                Throw new BadRequestException();
            }

            $this->validateJourneyIdRequest($journeyId);

            /** @var CarView $carView */
            $carView = $this->commandBus->handle(new RequestLocationCommand(
                (int)$journeyId,
            ));

            if (null === $carView) {
                return new Response(
                    null,
                    Response::HTTP_NO_CONTENT
                );
            }

            return new JsonResponse(
                ["id" => $carView->id(), "seats" => $carView->seats()],
                JsonResponse::HTTP_OK
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