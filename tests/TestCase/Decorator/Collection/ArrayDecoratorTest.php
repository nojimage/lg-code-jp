<?php

namespace Nojimage\LocalGovCode\TestCase\Decorator\Collection;

use PHPUnit\Framework\TestCase;
use Nojimage\LocalGovCode\Decorator\Collection\ArrayDecorator;

/**
 * test for ArrayDecorator
 */
class ArrayDecoratorTest extends TestCase
{

    /**
     * Nojimage\LocalGovCode\Decorator\Collection\ArrayDecorator::convert
     */
    public function testConvert()
    {
        $decorator = new ArrayDecorator();

        $records = array(array('id' => 1));

        $this->assertInternalType('array', $decorator->convert($records));
        $this->assertSame($records, $decorator->convert($records));
    }
}
