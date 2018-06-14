<?php

namespace Nojimage\LocalGovCode\Collection;

use ArrayObject;

/**
 * convert to ArrayObject
 */
class ArrayObjectProvider implements CollectionProviderInferface
{

    /**
     * convert to ArrayObject
     *
     * @param array $records
     * @return ArrayObject
     */
    public function convert(array $records)
    {
        return new ArrayObject($records);
    }
}
