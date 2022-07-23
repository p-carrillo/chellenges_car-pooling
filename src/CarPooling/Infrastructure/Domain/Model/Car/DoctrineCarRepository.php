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

    public function create(array $carPool): void
    {
        $values = [];
        foreach ($carPool as $car) {
            $values[] = '(' . $car->id . ',' . $car->seats . ')';
        }

        $sql = 'INSERT INTO car (id, seats) VALUES ' . implode(',', $values);

        $this->connection->executeStatement($sql);
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