<?php

namespace Nojimage\LocalGovCode\Collection;

/**
 * Convert array to collection
 */
interface CollectionProviderInferface
{

    /**
     * Convert array to collection
     *
     * @param array $records
     * @return mixed Collection object
     */
    public function convert(array $records);
}
