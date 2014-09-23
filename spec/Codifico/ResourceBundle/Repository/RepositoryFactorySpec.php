<?php

namespace spec\Codifico\ResourceBundle\Repository;

use Codifico\ResourceBundle\Repository\RepositoryFactory;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepositoryFactorySpec extends ObjectBehavior
{
    function it_should_be_a_repository_factory()
    {
        $this->shouldHaveType('Codifico\ResourceBundle\Repository\RepositoryFactory');
    }

    function it_should_create_default_repository(EntityManagerInterface $entityManager)
    {
        $entityName = 'test';
        $entityManager->getRepository($entityName)->shouldBeCalled();
        $this->getRepository($entityManager, $entityName);
    }

    function it_should_create_custom_repository(EntityManagerInterface $entityManager)
    {
        $entityName = 'test';
        $repositoryClass = '\stdClass';

        $this->getRepository($entityManager, $entityName, $repositoryClass)
            ->shouldHaveType($repositoryClass);
    }
}