<?php

namespace Nojimage\LocalGovCode;

use Nojimage\LocalGovCode\Collection\CollectionProviderInferface;
use Nojimage\LocalGovCode\Datasource\Json;

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
     * @param CollectionProviderInferface $collectionProvider
     * @return Wards
     */
    public static function createFromJson(CollectionProviderInferface $collectionProvider = null)
    {
        return self::getInstance(new Json(Json::WARDS_JSON), $collectionProvider);
    }
}
