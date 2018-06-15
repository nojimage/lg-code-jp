<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Datasource\Json;
use Nojimage\LocalGovCode\Decorator\Collection\CollectionDecoratorInferface;
use Nojimage\LocalGovCode\Decorator\Entity\EntityDecoratorInferface;

/**
 * Wards
 */
class Wards extends Repository
{

    /**
     * @return string
     */
    protected function getNameField()
    {
        return 'ward_name';
    }

    /**
     * @param CollectionDecoratorInferface $collectionDecorator
     * @param EntityDecoratorInferface $entityDecorator
     * @return Wards
     */
    public static function createFromJson(CollectionDecoratorInferface $collectionDecorator = null, EntityDecoratorInferface $entityDecorator = null)
    {
        return self::getInstance(new Json(Json::WARDS_JSON), $collectionDecorator, $entityDecorator);
    }
}
