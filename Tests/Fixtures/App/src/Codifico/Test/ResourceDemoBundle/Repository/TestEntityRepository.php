<?php

namespace Codifico\Test\ResourceDemoBundle\Repository;

use Codifico\ResourceBundle\Repository\RepositoryDictionary;
use Codifico\ResourceBundle\Repository\EntityRepositoryInterface;
use Doctrine\ORM\EntityRepository as BaseEntityRepository;

class TestEntityRepository  extends BaseEntityRepository implements EntityRepositoryInterface {
    use RepositoryDictionary;
}