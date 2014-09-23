<?php

namespace Codifico\ResourceBundle\Repository;

interface EntityRepositoryInterface
{
    public function find($id);

    public function findAll();

    /**
     * @param integer $offset
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    public function findOneBy(array $criteria);

    /**
     * @return string
     */
    public function getClassName();

    public function create(array $arguments = null);

    /**
     * @return void
     */
    public function add($instance);

    /**
     * @return integer
     */
    public function count();
}
