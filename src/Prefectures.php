<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Datasource\Json;
use Nojimage\LocalGovCode\Decorator\Collection\CollectionDecoratorInferface;
use Nojimage\LocalGovCode\Decorator\Entity\EntityDecoratorInferface;

/**
 * Prefectures
 */
class Prefectures extends Repository
{

    /**
     * @return string
     */
    protected function getNameField()
    {
        return 'pref_name';
    }

    /**
     * @param CollectionDecoratorInferface $collectionDecorator
     * @param EntityDecoratorInferface $entityDecorator
     * @return Prefectures
     */
    public static function createFromJson(
        CollectionDecoratorInferface $collectionDecorator = null,
        EntityDecoratorInferface $entityDecorator = null
    ) {
        return self::getInstance(new Json(Json::PREFECTURES_JSON), $collectionDecorator, $entityDecorator);
    }
}
