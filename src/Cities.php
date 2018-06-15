<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Datasource\Json;
use Nojimage\LocalGovCode\Decorator\Collection\CollectionDecoratorInferface;
use Nojimage\LocalGovCode\Decorator\Entity\EntityDecoratorInferface;

/**
 * Cities
 */
class Cities extends Repository
{

    /**
     * @return string
     */
    protected function getNameField()
    {
        return 'city_name';
    }

    /**
     * @param CollectionDecoratorInferface $collectionDecorator
     * @param EntityDecoratorInferface $entityDecorator
     * @return Cities
     */
    public static function createFromJson(CollectionDecoratorInferface $collectionDecorator = null, EntityDecoratorInferface $entityDecorator = null)
    {
        return self::getInstance(new Json(Json::CITIES_JSON), $collectionDecorator, $entityDecorator);
    }
}
