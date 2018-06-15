<?php

namespace Nojimage\LocalGovCode\Decorator\Entity;

use Nojimage\LocalGovCode\LocalGovCodeObjectInterface;

/**
 * Convert array to Entity
 */
interface EntityDecoratorInferface
{

    /**
     * Convert array to local government object
     *
     * @param array $record
     * @return LocalGovCodeObjectInterface
     */
    public function convert(array $record);
}
