<?php

namespace Codifico\ResourceBundle\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory as BaseRepositoryFactory;

class RepositoryFactory implements BaseRepositoryFactory
{
    /**
     * Gets the repository for an entity class.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager The EntityManager instance.
     * @param string $entityName The name of the entity.
     * @param string $repositoryName Custom repository class
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository(EntityManagerInterface $entityManager, $entityName, $repositoryName = null)
    {
        if (null !== $repositoryName) {

            return new $repositoryName(
                $entityManager,
                $entityManager->getClassMetadata($entityName)
            );
        }

        return $entityManager->getRepository($entityName);
    }
} 