<?php

namespace Codifico\ResourceBundle\Repository;

trait RepositoryDictionary
{
    public abstract function getClassName();
    public abstract function getEntityManager();

    /**
     * @param string $alias
     */
    public abstract function createQueryBuilder($alias);

    public function create(array $arguments = null)
    {
        if (null === $arguments) {
            $classname = $this->getClassName();
            return new $classname;
        }

        $reflection = new \ReflectionClass($this->getClassName());

        return $reflection->newInstanceArgs($arguments);
    }

    public function add($instance)
    {
        $this->getEntityManager()->persist($instance);
    }

    public function count()
    {
        $queryBuilder = $this->createQueryBuilder($this->getAlias());
        $queryBuilder->select('COUNT(' . $this->getAlias() . '.id)');

        return (int)$queryBuilder->getQuery()->getSingleScalarResult();
    }

    protected function getAlias()
    {
        return 'a';
    }
}
