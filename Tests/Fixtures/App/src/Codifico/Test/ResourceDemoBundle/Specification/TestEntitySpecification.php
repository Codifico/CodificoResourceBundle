<?php

namespace Codifico\Test\ResourceDemoBundle\Specification;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

class TestEntitySpecification extends BaseSpecification
{
    public function __construct($dqlAlias = null)
    {
        parent::__construct($dqlAlias);
        $this->spec = Spec::eq('id', $id);
    }
    /**
     * @param string $className
     *
     * @return bool
     */
    public function supports($className)
    {
        return $className === 'Codifico\Test\ResourceDemoBundle\Entity\TestEntity';
    }
}