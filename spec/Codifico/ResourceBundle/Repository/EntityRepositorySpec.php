<?php

namespace spec\Codifico\ResourceBundle\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EntityRepositorySpec extends ObjectBehavior
{
    function let(EntityManagerInterface $entityManager, ClassMetadata $metadata, QueryBuilder $queryBuilder)
    {
        $metadata->name = 'test-meta';
        $entityManager->createQueryBuilder(Argument::any())
            ->willReturn($queryBuilder);
        $this->beConstructedWith($entityManager, $metadata);
    }

    function it_should_have_type()
    {
        $this->shouldHaveType('Codifico\ResourceBundle\Repository\EntityRepository');
    }

    function it_should_be_able_to_count(QueryBuilder $queryBuilder, AbstractQuery $query)
    {
        $queryBuilder->select(Argument::any())->willReturn($queryBuilder);
        $queryBuilder->from(Argument::any(), Argument::any())->willReturn($queryBuilder);
        $queryBuilder->getQuery()->willReturn($query);

        $query->getSingleScalarResult()->willReturn(1);
        $this->count()->shouldReturn(1);
    }
}