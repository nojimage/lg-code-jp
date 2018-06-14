<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Collection\CollectionProviderInferface;
use Nojimage\LocalGovCode\Datasource\Json;

/**
 * Cities
 */
class Cities extends Repository
{

    /**
     * @param array $data
     * @return City
     */
    protected function convertToObject(array $data)
    {
        return new City($data);
    }

    /**
     * @return string
     */
    protected function getNameField()
    {
        return 'city_name';
    }

    /**
     * @param CollectionProviderInferface $collectionProvider
     * @return Cities
     */
    public static function createFromJson(CollectionProviderInferface $collectionProvider = null)
    {
        return self::getInstance(new Json(Json::CITIES_JSON), $collectionProvider);
    }
}
