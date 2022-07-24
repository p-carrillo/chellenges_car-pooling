<?php

declare(strict_types=1);

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Journey;

use App\CarPooling\Application\Command\Journey\RequestDropOff\RequestDropOffCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            $journeyId = $request->get('ID') ?? $request->get('id');
            $this->commandBus->handle(new RequestDropOffCommand(
                (int)$journeyId,
            ));

            return new JsonResponse(
                '',
                JsonResponse::HTTP_OK
            );
        } catch (NotFoundHttpException $exception) {
            return new JsonResponse(
                '',
                JsonResponse::HTTP_NOT_FOUND
            );
        } catch (BadRequestException $exception) {
            return new JsonResponse(
                '',
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}