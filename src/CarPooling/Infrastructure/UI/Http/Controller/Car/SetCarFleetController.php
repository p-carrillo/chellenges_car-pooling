<?php

declare(strict_types=1);

namespace App\CarPooling\Infrastructure\UI\Http\Controller\Car;

use App\CarPooling\Application\Command\Car\SetCarFleet\SetCarFleetCommand;
use App\CarPooling\Domain\Model\Car\Car;
use Doctrine\DBAL\Types\Types;
use JsonException;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TypeError;

class SetCarFleetController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request) :Response
    {
        try {
            $carFleet = $this->createCarFleetOrFail($request);

            $this->commandBus->handle(new SetCarFleetCommand(
                $carFleet
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

    private function createCarFleetOrFail(Request $request) :array
    {
        if ($request->getContentType() !== Types::JSON) {
            throw new TypeError();
        }

        $fleetRequest = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        foreach ($fleetRequest as $carRequest) {
            $this->validateCarRequest($carRequest);
            $carFleet[] = Car::create($carRequest['id'], $carRequest['seats']);
        }

        return $carFleet;
    }

    private function validateCarRequest( array $carRequest) :void
    {
        if ( !isset($carRequest['id']) || !isset($carRequest['seats']))  {
            Throw new TypeError();
        }
    }
}