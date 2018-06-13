<?php

namespace Nojimage\LocalGovCode\Datasource;

/**
 * Datasource
 */
interface DatasourceInterface
{

    /**
     * find by conditions
     *
     * @param array $conditions search conditions
     * @return array matched resources
     */
    public function find(array $conditions);

    /**
     * find by local government code
     *
     * @param string $code A Local government code
     * @return array|null matched resource
     */
    public function findByCode($code);

    /**
     * find by region name
     *
     * @param string $name A full region name
     * @return array|null matched resource
     */
    public function findByName($name);
}
