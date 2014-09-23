<?php

namespace spec\Codifico\ResourceBundle\Repository;

use Codifico\ResourceBundle\Repository\InMemoryRepository;
use Codifico\Test\ResourceDemoBundle\Entity\TestEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryRepositorySpec extends ObjectBehavior
{
    function let(EntityManagerInterface $entityManager, ClassMetadata $metadata)
    {
        $metadata->name = 'test-meta';
        $this->beConstructedWith($entityManager, $metadata);
    }

    function it_should_have_type()
    {
        $this->shouldHaveType('Codifico\ResourceBundle\Repository\InMemoryRepository');
    }

    function it_should_be_able_add_instance_to_collection()
    {
        $this->count()->shouldReturn(0);
        $this->add('1');
        $this->count()->shouldReturn(1);
    }

    function it_should_be_able_to_search_instance(TestEntity $entity)
    {
        $entity->getName()->willReturn('value');
        $this->add($entity);

        $this->findOneBy(['name' => 'value'])
            ->shouldReturn($entity);
    }

    function it_should_be_able_to_search_collection(TestEntity $entity)
    {
        $entity->getId()->willReturn('1');
        $this->add($entity);

        $this->find('1')
            ->shouldReturn($entity);
    }

    function it_should_return_class_name_from_metadata(ClassMetadata $metadata)
    {
        $this->getClassName()->shouldReturn($metadata->name);
    }

    function it_should_return_all_objects()
    {
        $this->findAll()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function it_should_be_able_to_advanced_search(TestEntity $entity1, TestEntity $entity2)
    {
        $entity1->getName()->willReturn('value');
        $entity2->getName()->willReturn('value');
        $this->add($entity1);
        $this->add($entity2);

        $collection = new ArrayCollection();
        $collection->add($entity1);
        $collection->add($entity2);

        $this->findBy(['name' => 'value'])
            ->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');

        $this->findBy(['name' => 'value'])
            ->shouldHaveCount(2);
    }

    function it_should_apply_order(TestEntity $entity1, TestEntity $entity2)
    {
        $entity1->getName()->willReturn('value');
        $entity2->getName()->willReturn('value');
        $entity1->getId()->willReturn(2);
        $entity2->getId()->willReturn(1);

        $this->add($entity1);
        $this->add($entity2);

        $this->findBy(['name' => 'value'], ['id' => 'desc'])
            ->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');

        $this->findBy(['name' => 'value'], ['id' => 'asc'])
            ->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
    }

    function it_should_apply_limit(TestEntity $entity1, TestEntity $entity2)
    {
        $entity1->getName()->willReturn('value');
        $entity2->getName()->willReturn('value');
        $entity1->getId()->willReturn(2);
        $entity2->getId()->willReturn(1);

        $this->add($entity1);
        $this->add($entity2);

        $this->findBy(['name' => 'value'], ['id' => 'desc'], 2)
            ->shouldHaveCount(2);

        $this->findBy(['name' => 'value'], ['id' => 'asc'], 1)
            ->shouldHaveCount(1);
    }
}