<?php

namespace Nojimage\LocalGovCode\Collection;

/**
 * convert to array
 */
class ArrayProvider implements CollectionProviderInferface
{

    /**
     * Through records
     *
     * @param array $records
     * @return array
     */
    public function convert(array $records)
    {
        return $records;
    }
}
