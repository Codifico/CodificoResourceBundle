<?php

namespace Codifico\ResourceBundle\Repository;

use Codifico\ResourceBundle\Repository\RepositoryDictionary;
use Doctrine\ORM\EntityRepository as BaseEntityRepository;

class EntityRepository  extends BaseEntityRepository implements EntityRepositoryInterface {
    use RepositoryDictionary;
}