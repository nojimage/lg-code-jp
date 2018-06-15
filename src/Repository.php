<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Datasource\DatasourceInterface;
use Nojimage\LocalGovCode\Decorator\Collection\ArrayDecorator;
use Nojimage\LocalGovCode\Decorator\Collection\CollectionDecoratorInferface;
use Nojimage\LocalGovCode\Decorator\Entity\EntityDecoratorInferface;
use Nojimage\LocalGovCode\Decorator\Entity\DefaultEntityDecorator;
use Nojimage\LocalGovCode\Exception\CodeNotFoundException;
use Nojimage\LocalGovCode\Exception\NameNotFoundException;

/**
 * Data repository
 */
abstract class Repository
{

    /**
     * @var DatasourceInterface
     */
    private $ds;

    /**
     * @var CollectionDecoratorInferface
     */
    private $collectionDecorator;

    /**
     * @var EntityDecoratorInferface
     */
    private $entityDecorator;

    /**
     * Create form Json datasource
     *
     * @param CollectionDecoratorInferface $collectionDecorator
     * @param EntityDecoratorInferface $entityDecorator
     * @return Repository
     */
    abstract public static function createFromJson(CollectionDecoratorInferface $collectionDecorator = null, EntityDecoratorInferface $entityDecorator = null);

    /**
     * Create repository
     *
     * @param DatasourceInterface $datasource
     * @param CollectionDecoratorInferface $collectionDecorator
     * @param EntityDecoratorInferface $entityDecorator
     * @return Repository
     */
    public static function getInstance(DatasourceInterface $datasource, CollectionDecoratorInferface $collectionDecorator = null, EntityDecoratorInferface $entityDecorator = null)
    {
        $class = get_called_class();

        return new $class($datasource, $collectionDecorator);
    }

    /**
     * constructor
     *
     * @param DatasourceInterface $datasource
     * @param CollectionDecoratorInferface $collectionDecorator
     * @param EntityDecoratorInferface $entityDecorator
     */
    public function __construct(DatasourceInterface $datasource, CollectionDecoratorInferface $collectionDecorator = null, EntityDecoratorInferface $entityDecorator = null)
    {
        if (!isset($collectionDecorator)) {
            $collectionDecorator = new ArrayDecorator();
        }
        if (!isset($entityDecorator)) {
            $entityDecorator = new DefaultEntityDecorator();
        }

        $this->setDatasource($datasource);
        $this->setCollectionDecorator($collectionDecorator);
        $this->setEntityDecorator($entityDecorator);
    }

    /**
     * Set datasource
     *
     * @param DatasourceInterface $datasource
     * @return void
     */
    public function setDatasource(DatasourceInterface $datasource)
    {
        $this->ds = $datasource;
    }

    /**
     * Set entity decorator
     *
     * @param EntityDecoratorInferface $entityDecorator
     * @return void
     */
    public function setEntityDecorator(EntityDecoratorInferface $entityDecorator)
    {
        $this->entityDecorator = $entityDecorator;
    }

    /**
     * Set collection decorator
     *
     * @param CollectionDecoratorInferface $collectionDecorator
     * @return void
     */
    public function setCollectionDecorator(CollectionDecoratorInferface $collectionDecorator)
    {
        $this->collectionDecorator = $collectionDecorator;
    }

    /**
     * A name field name when using findByName
     *
     * @return string
     */
    abstract protected function getNameField();

    /**
     * Get a object by code
     *
     * @param string $code
     * @return LocalGovCodeObjectInterface
     * @throws CodeNotFoundException
     */
    public function get($code)
    {
        $result = $this->ds->findByCode($code);

        if (empty($result)) {
            throw new CodeNotFoundException;
        }

        return $this->entityDecorator->convert($result);
    }

    /**
     * Get a object by name
     *
     * @param string $name a full name of region
     * @return LocalGovCodeObjectInterface
     * @throws NameNotFoundException
     */
    public function getByName($name)
    {
        $result = $this->ds->findByName($name);

        if (empty($result)) {
            throw new NameNotFoundException;
        }

        return $this->entityDecorator->convert($result);
    }

    /**
     * Get code by name
     *
     * @param string $name
     * @return string a code of region
     */
    public function getCode($name)
    {
        return $this->getByName($name)->code;
    }

    /**
     * Get name by code
     *
     * @param string $code
     * @return string a full name of region
     */
    public function getName($code)
    {
        return $this->get($code)->name;
    }

    /**
     * Is code valid
     *
     * @param string $code
     * @return bool
     */
    public function isValidCode($code)
    {
        try {
            $this->get($code);

            return true;
        } catch (CodeNotFoundException $e) {
            return false;
        }

        return false;
    }

    /**
     * Is name valid
     *
     * @param string $name
     * @return bool
     */
    public function isValidName($name)
    {
        try {
            $this->getByName($name);

            return true;
        } catch (NameNotFoundException $e) {
            return false;
        }

        return false;
    }

    /**
     * Find a objects
     *
     * @param array $conditions
     * @return LocalGovCodeObjectInterface[]|array
     */
    public function find(array $conditions)
    {
        $results = $this->ds->find($conditions);
        $objects = array_map(array($this->entityDecorator, 'convert'), $results);

        return $this->collectionDecorator->convert($objects);
    }

    /**
     * Find a objects by name
     *
     * @param string $name
     * @return LocalGovCodeObjectInterface[]|array
     */
    public function findByName($name)
    {
        $conditions = array($this->getNameField() => $name);

        return $this->find($conditions);
    }
}
