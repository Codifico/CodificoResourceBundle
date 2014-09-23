<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\ORM\Tools\SchemaTool;
use Behat\Gherkin\Node\PyStringNode;
/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext
{
    use KernelDictionary;

    protected $instance;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $service;

    /**
     * @Given Database is empty
     */
    public function databaseIsEmpty()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $schemaTool = new SchemaTool($em);
        $metadata = $em->getMetadataFactory()->getAllMetadata();

        $schemaTool->dropDatabase($metadata);
        $schemaTool->createSchema($metadata);
    }

    /**
     * @When I get :name service
     */
    public function iGetService($name)
    {
        $this->service = $this->getContainer()->get($name);
    }

    /**
     * @When I create new instance of resource
     */
    public function iCreateNewInstanceOfResource2()
    {
        $this->instance = $this->service->create();
    }

    /**
     * @Then I should get object :classname
     */
    public function iShouldGetObject($classname)
    {
        if (!$this->instance) {
            throw new DomainException("Instance of object has not been initialized.");
        }

        if (!$this->instance instanceof $classname) {
            throw new DomainException(sprintf(
                "Expecting %s instance but got %s",
                $classname,
                get_class($this->instance)
            ));
        }
    }

    /**
     * @When I set for entity properties:
     */
    public function entityExistsWith(TableNode $table)
    {
        if (!$this->instance) {
            throw new DomainException("Instance of object has not been initialized.");
        }

        foreach ($table->getHash() as $row) {
            $name = $row['property name'];
            $value = $row['property value'];

            $method = 'set' . ucfirst($name);
            if (!method_exists($this->instance, $method)) {
                throw new DomainException(sprintf(
                   "Instance of %s does not have method %s",
                    get_class($this->instance),
                    $method
                ));
            }
            $this->instance->$method($value);
        }
    }

    /**
     * @When I add entity to collection
     */
    public function iAddEntityToCollection()
    {
        $this->service->add($this->instance);
    }

    /**
     * @When call persisting layer
     */
    public function callPersistingLayer()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        try {
            $em->flush($this->instance);
        } catch (InvalidArgumentException $e) {}
    }

    /**
     * @When I search for resource with property :property equals to :value
     */
    public function iSearchForResourceWith($property, $value)
    {
        $this->instance = $this->service->findOneBy([$property => $value]);
    }

    /**
     * @Then object property :property should be equals to :value
     */
    public function objectPropertyShouldBeEqualsTo($property, $value)
    {
        if (!$this->instance) {
            throw new DomainException("Instance of object has not been initialized.");
        }

        $method = 'get' . ucfirst($property);
        if (!method_exists($this->instance, $method)) {
            throw new DomainException(sprintf(
                "Instance of %s does not have method %s",
                get_class($this->instance),
                $method
            ));
        }

        if ($value !== $this->instance->$method()) {
            throw new \Exception(sprintf(
                "Expecting %s to be equals to %s",
                $value,
                $this->instance->$method()
            ));
        }
    }

    /**
     * @Given File :filename contans:
     */
    public function fileContans($filename, PyStringNode $string)
    {
    }

    /**
     * @Then It should be instance of :classname
     */
    public function itShouldBeInstanceOf($classname)
    {
        if (!$this->service) {
            throw new DomainException("Service has not been initialized.");
        }

        if (!$this->service instanceof $classname) {
            throw new DomainException(sprintf(
                "Expecting %s service but got %s",
                $classname,
                get_class($this->service)
            ));
        }
    }
}
