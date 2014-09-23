Feature: Repository service
  In order to access repository
  as a developer
  I need to have service

  Scenario: Access to srvice
    Given File "app/config/config.yml" contans:
    """
      codifico_resource:
          entities:
              test_entity:
                  class: Codifico\Test\ResourceDemoBundle\Entity\TestEntity
                  repository_class: Codifico\ResourceBundle\Repository\EntityRepository

              test_entity_custom:
                  class: Codifico\Test\ResourceDemoBundle\Entity\TestEntity

              test_entity_memory:
                  class: Codifico\Test\ResourceDemoBundle\Entity\TestEntity
                  factory_service: codifico.resource.repository_factory
                  factory_method: getRepository
                  repository_prefix: 'codifico.resource.repository.'
                  repository_class: Codifico\ResourceBundle\Repository\InMemoryRepository
    """
    When I get "codifico.resource.repository.test_entity" service
    Then It should be instance of "Codifico\ResourceBundle\Repository\EntityRepository"

    When I get "codifico.resource.repository.test_entity_custom" service
    Then It should be instance of "Codifico\Test\ResourceDemoBundle\Repository\TestEntityRepository"

    When I get "codifico.resource.repository.test_entity_memory" service
    Then It should be instance of "Codifico\ResourceBundle\Repository\InMemoryRepository"