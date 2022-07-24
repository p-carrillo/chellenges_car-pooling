<?php

namespace App\CarPooling\Infrastructure\Domain\Model\Journey;

use App\CarPooling\Domain\Model\Journey\Journey;
use App\CarPooling\Domain\Model\Journey\JourneyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineJourneyRepository extends ServiceEntityRepository implements JourneyRepositoryInterface
{
    protected Connection $connection;

    public function __construct( ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Journey::class);
        $this->connection = $entityManager->getConnection();
    }

    public function getOneById(int $id): ?Journey
    {
        $qb = $this->createQueryBuilder('j')
            ->where('j.id = :id')
            ->setParameter('id', $id)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function create(Journey $journey): void
    {
        $sql = 'INSERT INTO journey (id, people, date_request)
                VALUES (:id, :people, :date_request)';

        $this->connection->executeStatement($sql, $this->saveParameters($journey));
    }

    public function update(Journey $journey): void
    {
        $qb = $this->createQueryBuilder('j');

        $qb->update('journey:Journey', 'j')
            ->set('j.carAssigned', ':carAssigned')
            ->where('j.id = :id')
            ->setParameter('id', $journey->id())
            ->setParameter('carAssigned', $journey->carAssigned())
            ->getQuery()
            ->execute();
    }

    public function reset(): void
    {
        $this->connection->executeStatement('DELETE FROM journey');
    }

    public function remove(Journey $journey): void
    {
        $sql = 'DELETE FROM journey 
            WHERE id = :id';
        $this->connection->executeStatement($sql, ['id' => $journey->id()]);
    }

    private function saveParameters(Journey $journey): array
    {
        return [
            'id' => $journey->id(),
            'people' => $journey->people(),
            'car_assigned' => $journey->carAssigned(),
            'date_request' => $journey->dateRequest()->format('Y-m-d H:i:s'),
        ];
    }

}