<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Collection\CollectionProviderInferface;
use Nojimage\LocalGovCode\Datasource\Json;

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
     * @param CollectionProviderInferface $collectionProvider
     * @return Prefectures
     */
    public static function createFromJson(CollectionProviderInferface $collectionProvider = null)
    {
        return self::getInstance(new Json(Json::PREFECTURES_JSON), $collectionProvider);
    }
}
