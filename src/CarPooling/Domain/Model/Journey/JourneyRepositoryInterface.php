<?php

declare(strict_types=1);

namespace App\CarPooling\Domain\Model\Journey;

interface JourneyRepositoryInterface
{
    public function getOneById(int $id): ?Journey;

    public function create(Journey $journey): void;

    public function update(Journey $journey): void;

    public function reset(): void;
}
