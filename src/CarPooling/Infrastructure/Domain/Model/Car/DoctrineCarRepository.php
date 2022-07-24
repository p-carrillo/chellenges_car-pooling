<?php

namespace App\CarPooling\Infrastructure\Domain\Model\Car;

use App\CarPooling\Domain\Model\Car\Car;
use App\CarPooling\Domain\Model\Car\CarRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineCarRepository extends ServiceEntityRepository implements CarRepositoryInterface
{
    protected Connection $connection;

    public function __construct( ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Car::class);
        $this->connection = $entityManager->getConnection();
    }

    public function getOneById(int $id): ?car
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.id = :id')
            ->setParameter('id', $id)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function loadCarFleet(array $carFleet): void
    {
        $values = [];
        /** @var Car $car */
        foreach ($carFleet as $car) {
            $values[] = '('
                . $car->id() . ','
                . $car->seats() . ','
                . $car->seatsAvailable() .
        ')';
        }

        $sql = 'INSERT INTO car (id, seats, seats_available) VALUES ' . implode(',', $values);

        $this->connection->executeStatement($sql);
    }

    public function update(Car $car): void
    {
        $qb = $this->createQueryBuilder('c');

        $qb->update('car:Car', 'c')
            ->set('c.seatsAvailable', ':seatsAvailable')
            ->where('c.id = :id')
            ->setParameter('id', $car->id())
            ->setParameter('seatsAvailable', $car->seatsAvailable())
            ->getQuery()
            ->execute();
    }

    public function reset(): void
    {
        $this->connection->executeStatement('DELETE FROM car');
    }

    public function findAvailableCar(int $seatsRequested): ?car
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.seatsAvailable >= :seatsAvailable')
            ->setParameter('seatsAvailable', $seatsRequested)
            ->orderBy('c.seatsAvailable', 'ASC')
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    private function saveParameters(\stdClass $car): array
    {
        return [
            'id' => $car->id,
            'seats' => $car->seats,
        ];
    }

}