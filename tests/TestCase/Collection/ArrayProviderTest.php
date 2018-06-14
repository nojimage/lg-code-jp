<?php

namespace Nojimage\LocalGovCode\TestCase\Collection;

use PHPUnit\Framework\TestCase;
use Nojimage\LocalGovCode\Collection\ArrayProvider;

/**
 * test for ArrayProvider
 */
class ArrayProviderTest extends TestCase
{

    /**
     * @covers Nojimage\LocalGovCode\Collection\ArrayProvider::convert
     */
    public function testConvert()
    {
        $provider = new ArrayProvider();

        $records = array(array('id' => 1));

        $this->assertInternalType('array', $provider->convert($records));
        $this->assertSame($records, $provider->convert($records));
    }
}
