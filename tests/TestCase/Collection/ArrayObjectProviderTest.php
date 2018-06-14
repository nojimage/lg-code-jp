<?php

namespace Nojimage\LocalGovCode\TestCase\Collection;

use PHPUnit\Framework\TestCase;
use Nojimage\LocalGovCode\Collection\ArrayObjectProvider;

/**
 * test for ArrayObjectProvider
 */
class ArrayObjectProviderTest extends TestCase
{

    /**
     * @covers Nojimage\LocalGovCode\Collection\ArrayObjectProvider::convert
     */
    public function testConvert()
    {
        $provider = new ArrayObjectProvider();

        $records = array(array('id' => 1));

        $this->assertInstanceOf('\ArrayObject', $provider->convert($records));
        $this->assertSame($records, $provider->convert($records)->getArrayCopy());
    }
}
