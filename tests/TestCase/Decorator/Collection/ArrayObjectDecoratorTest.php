<?php

namespace Nojimage\LocalGovCode\TestCase\Decorator\Collection;

use PHPUnit\Framework\TestCase;
use Nojimage\LocalGovCode\Decorator\Collection\ArrayObjectDecorator;

/**
 * test for ArrayObjectDecorator
 */
class ArrayObjectDecoratorTest extends TestCase
{

    /**
     * Nojimage\LocalGovCode\Decorator\Collection\ArrayObjectDecorator::convert
     */
    public function testConvert()
    {
        $decorator = new ArrayObjectDecorator();

        $records = array(array('id' => 1));

        $this->assertInstanceOf('\ArrayObject', $decorator->convert($records));
        $this->assertSame($records, $decorator->convert($records)->getArrayCopy());
    }
}
