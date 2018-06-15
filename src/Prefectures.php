<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Datasource\Json;
use Nojimage\LocalGovCode\Decorator\Collection\CollectionDecoratorInferface;

/**
 * Prefectures
 */
class Prefectures extends Repository
{

    /**
     * @param array $data
     * @return Prefecture
     */
    protected function convertToObject(array $data)
    {
        return new Prefecture($data);
    }

    /**
     * @return string
     */
    protected function getNameField()
    {
        return 'pref_name';
    }

    /**
     * @param CollectionDecoratorInferface $collectionDecorator
     * @return Prefectures
     */
    public static function createFromJson(CollectionDecoratorInferface $collectionDecorator = null)
    {
        return self::getInstance(new Json(Json::PREFECTURES_JSON), $collectionDecorator);
    }
}
