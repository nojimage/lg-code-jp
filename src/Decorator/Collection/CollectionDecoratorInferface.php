<?php

namespace Nojimage\LocalGovCode\Decorator\Collection;

/**
 * Convert array to collection
 */
interface CollectionDecoratorInferface
{

    /**
     * Convert array to collection
     *
     * @param array $records
     * @return mixed Collection object
     */
    public function convert(array $records);
}
