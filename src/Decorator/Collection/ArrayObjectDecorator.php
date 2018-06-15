<?php

namespace Nojimage\LocalGovCode\Decorator\Collection;

use ArrayObject;

/**
 * convert to ArrayObject
 */
class ArrayObjectDecorator implements CollectionDecoratorInferface
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
