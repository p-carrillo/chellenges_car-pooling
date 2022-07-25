<?php

declare(strict_types=1);

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Car;

use App\CarPooling\Application\Command\Car\SetCarFleet\SetCarFleetCommand;
use App\CarPooling\Domain\Model\Car\Car;
use Doctrine\DBAL\Types\Types;
use Gonsandia\CarPoolingChallenge\Infrastructure\Exception\InvalidContentTypeException;
use League\Tactician\CommandBus;
use PhpParser\Node\Expr\Throw_;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TypeError;

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
            $carFleet = $this->createCarFleetOrFail($request);

            $this->commandBus->handle(new SetCarFleetCommand(
                $carFleet
            ));

            return new JsonResponse(
                'Car fleet has been loaded',
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

    private function createCarFleetOrFail(Request $request) :array
    {
        if ($request->getContentType() !== Types::JSON) {
            throw new TypeError();
        }

        $fleetRequest = json_decode($request->getContent());

        foreach ($fleetRequest as $carRequest) {
            $this->validateCarRequest($carRequest);
            $carFleet[] = Car::create($carRequest->id, $carRequest->seats);
        }

        return $carFleet;
    }

    private function validateCarRequest( \stdClass $carRequest) :void
    {
        if ( !isset($carRequest->id) || !isset($carRequest->seats))  {
            Throw new TypeError();
        }
    }
}