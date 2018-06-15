<?php

namespace Nojimage\LocalGovCode\Decorator\Collection;

/**
 * convert to array
 */
class ArrayDecorator implements CollectionDecoratorInferface
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
