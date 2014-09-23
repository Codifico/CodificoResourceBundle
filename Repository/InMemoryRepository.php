<?php

namespace Codifico\ResourceBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ClassMetadata;
use Happyr\DoctrineSpecification\Specification;
use Happyr\DoctrineSpecification\Result\Modifier;

class InMemoryRepository implements EntityRepositoryInterface {
    use RepositoryDictionary;

    protected $collection;
    protected $className;

    public function __construct($em, ClassMetadata $class)
    {
        $this->className = $class->name;
        $this->collection = new ArrayCollection();
    }

    public function add($instance)
    {
        $this->collection->add($instance);
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function findOneBy(array $criteria)
    {
        return $this->findBy($criteria)->first();
    }

    public function find($id)
    {
        return $this->collection->filter(function($element) use ($id) {
            return $element->getId() === $id;
        })->first();
    }

    public function findAll()
    {
        return $this->collection;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = 0)
    {
        $result = new ArrayCollection();
        foreach ($this->collection as $element) {
            $match = true;
            foreach ($criteria as $property => $value) {
                $method = $this->getMethodName($property);
                $match = $element->$method() === $value;

                if (!$match) {
                    break;
                }
            }

            if ($match) {
                $result->add($element);
            }
        }

        $result = $this->applyOrderBy($result, $orderBy);
        $result = $this->applyLimitAndOffset($result, $limit, $offset);
        return $result;
    }

    public function count()
    {
        return $this->collection->count();
    }

    protected function applyOrderBy(ArrayCollection $collection, $orderBy = null)
    {
        if (!$orderBy || !is_array($orderBy)) {
            return $collection;
        }

        $property = key($orderBy);
        $order = $orderBy[$property];

        $iterator = $collection->getIterator();
        $data = iterator_to_array($iterator);

        if ($order !== 'asc') {
            $data = array_reverse($data);
        }

        sort($data);

        return new ArrayCollection($data);
    }

    protected function applyLimitAndOffset(ArrayCollection $collection, $limit, $offset)
    {
        $data = $collection->slice($offset, $limit);

        return new ArrayCollection($data);
    }

    protected function getMethodName($property)
    {
        return 'get' . ucfirst($property);
    }

    public function getEntityManager()
    {
    }

    public function createQueryBuilder()
    {
    }
}