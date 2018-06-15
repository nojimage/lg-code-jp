<?php

namespace Nojimage\LocalGovCode\Decorator\Entity;

use Nojimage\LocalGovCode\City;
use Nojimage\LocalGovCode\LocalGovCodeObject;
use Nojimage\LocalGovCode\LocalGovCodeObjectInterface;
use Nojimage\LocalGovCode\Prefecture;
use Nojimage\LocalGovCode\Ward;

/**
 * DefaultEntityDecorator
 */
class DefaultEntityDecorator implements EntityDecoratorInferface
{
    /**
     * {@inheritDoc}
     *
     * @param array $record
     * @return LocalGovCodeObjectInterface|Prefecture|City|Ward|LocalGovCodeObject
     */
    public function convert(array $record)
    {
        if (!isset($record['type'])) {
            throw new \InvalidArgumentException('Can\'t convert to object. Invalid data structure.');
        }

        $className = '\\Nojimage\\LocalGovCode\\' . LocalGovCodeObject::camelize($record['type']);

        if (!class_exists($className)) {
            $className = '\\Nojimage\\LocalGovCode\\LocalGovCodeObject';
        }

        return new $className($record);
    }
}
