<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Datasource\Json;
use Nojimage\LocalGovCode\Decorator\Collection\CollectionDecoratorInferface;

/**
 * Wards
 */
class Wards extends Repository
{

    /**
     * @param array $data
     * @return Ward
     */
    protected function convertToObject(array $data)
    {
        return new Ward($data);
    }

    /**
     * @return string
     */
    protected function getNameField()
    {
        return 'ward_name';
    }

    /**
     * @param CollectionDecoratorInferface $collectionDecorator
     * @return Wards
     */
    public static function createFromJson(CollectionDecoratorInferface $collectionDecorator = null)
    {
        return self::getInstance(new Json(Json::WARDS_JSON), $collectionDecorator);
    }
}
