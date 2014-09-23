Feature: resource
  In order to access resource
  as a developer
  I need resource service
  Background:
    Given Database is empty

  Scenario: Create entity
    When I get "codifico.resource.repository.test_entity" service
    And  I create new instance of resource
    Then I should get object "Codifico\Test\ResourceDemoBundle\Entity\TestEntity"

  Scenario: Find entity
    When I get "codifico.resource.repository.test_entity" service
    And  I create new instance of resource
    And I set for entity properties:
      | property name | property value |
      | name          | Test           |
    And I add entity to collection
    And call persisting layer
    And I search for resource with property "name" equals to "Test"
    Then I should get object "Codifico\Test\ResourceDemoBundle\Entity\TestEntity"
    And object property "name" should be equals to "Test"

  Scenario: Create entity
    When I get "codifico.resource.repository.test_entity_memory" service
    And  I create new instance of resource
    Then I should get object "Codifico\Test\ResourceDemoBundle\Entity\TestEntity"

  Scenario: Find entity
    When I get "codifico.resource.repository.test_entity_memory" service
    And  I create new instance of resource
    And I set for entity properties:
      | property name | property value |
      | name          | Test           |
    And I add entity to collection
    And call persisting layer
    And I search for resource with property "name" equals to "Test"
    Then I should get object "Codifico\Test\ResourceDemoBundle\Entity\TestEntity"
    And object property "name" should be equals to "Test"