<?php
// src/AppBundle/Repository/ProductRepository.php
namespace OCROnline\Repository;

use Doctrine\ORM\EntityRepository;

class DocumentRepository extends EntityRepository
{
    public function findPublicOrderedByNewest()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT d FROM OCROnline\Entity\Document d WHERE d.privacy=0 ORDER BY d.creationDatetime DESC'
            )->setMaxResults(20)
            ->getResult();
    }
}