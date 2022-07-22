<?php

namespace App\CarPooling\Infrastructure\Domain\Model\Car;

use App\CarPooling\Domain\Model\Car\Car;
use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCarRepository implements CarRepositoryInterface
{
    protected Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
    }

    public function getById(int $id): ?array
    {
        $statement = $this->connection->executeQuery(
            'SELECT * FROM car WHERE id = :id',
            ['id' => $id]
        );

        return $statement->fetchAssociative();
    }

    public function create(\stdClass $car): void
    {

        $sql = 'INSERT INTO car VALUES
                (:id, :seats)';

        $this->connection->executeStatement($sql, $this->saveParameters($car));
    }

    public function update(Car $car): void
    {

    }

    private function saveParameters(\stdClass $car): array
    {
        return [
            'id' => $car->id,
            'seats' => $car->seats,
        ];
    }

}