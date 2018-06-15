<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Datasource\Json;
use Nojimage\LocalGovCode\Decorator\Collection\CollectionDecoratorInferface;

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
     * @param CollectionDecoratorInferface $collectionDecorator
     * @return Cities
     */
    public static function createFromJson(CollectionDecoratorInferface $collectionDecorator = null)
    {
        return self::getInstance(new Json(Json::CITIES_JSON), $collectionDecorator);
    }
}
