<?php

namespace Codifico\ResourceBundle\Repository;

interface EntityRepositoryInterface
{
    public function find($id);

    public function findAll();

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    public function findOneBy(array $criteria);

    public function getClassName();

    public function create(array $arguments = null);

    public function add($instance);

    public function count();
}
