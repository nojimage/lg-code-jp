<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Datasource\DatasourceInterface;
use Nojimage\LocalGovCode\Decorator\Collection\ArrayDecorator;
use Nojimage\LocalGovCode\Decorator\Collection\CollectionDecoratorInferface;
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
     * Create form Json datasource
     *
     * @param CollectionDecoratorInferface $collectionDecorator
     * @return Repository
     */
    abstract public static function createFromJson(CollectionDecoratorInferface $collectionDecorator = null);

    /**
     * Create repository
     *
     * @param DatasourceInterface $datasource
     * @param CollectionDecoratorInferface $collectionDecorator
     * @return Repository
     */
    public static function getInstance(DatasourceInterface $datasource, CollectionDecoratorInferface $collectionDecorator = null)
    {
        $class = get_called_class();

        if (!isset($collectionDecorator)) {
            $collectionDecorator = new ArrayDecorator();
        }

        return new $class($datasource, $collectionDecorator);
    }

    /**
     * constructor
     *
     * @param DatasourceInterface $datasource
     */
    public function __construct(DatasourceInterface $datasource, CollectionDecoratorInferface $collectionDecorator)
    {
        $this->setDatasource($datasource);
        $this->setCollectionDecorator($collectionDecorator);
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
     * Set collection provider
     *
     * @param CollectionDecoratorInferface $collectionDecorator
     * @return void
     */
    public function setCollectionDecorator(CollectionDecoratorInferface $collectionDecorator)
    {
        $this->collectionProvider = $collectionDecorator;
    }

    /**
     * Convert array to object
     *
     * @param array $data
     * @return LocalGovCodeObjectInterface
     */
    abstract protected function convertToObject(array $data);

    /**
     * name field name when using findByName
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

        return $this->convertToObject($result);
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

        return $this->convertToObject($result);
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
     * Convert array to collection
     *
     * @param array $records
     * @return mixed a Collection object
     */
    protected function convertCollection(array $records)
    {
        return $this->collectionProvider->convert($records);
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
        $objects = array_map(array($this, 'convertToObject'), $results);

        return $this->convertCollection($objects);
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
