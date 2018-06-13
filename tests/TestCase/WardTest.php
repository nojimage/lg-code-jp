<?php

namespace Nojimage\LocalGovCode\TestCase;

use Nojimage\LocalGovCode\Ward;
use PHPUnit\Framework\TestCase;

/**
 * test for Ward
 */
class WardTest extends TestCase
{

    /**
     * @var Ward
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Ward(array(
            'type' => 'ward',
            'code' => '011011',
            'name' => '北海道札幌市中央区',
            'kana' => 'ほっかいどうさっぽろしちゅうおうく',
            'ward_code' => '011011',
            'ward_name' => '中央区',
            'ward_kana' => 'ちゅうおうく',
            'city_code' => '011002',
            'city_name' => '札幌市',
            'city_kana' => 'さっぽろし',
            'pref_code' => '010006',
            'pref_name' => '北海道',
            'pref_kana' => 'ほっかいどう'
        ));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * check implement
     */
    public function testInitialize()
    {
        $this->assertInstanceOf('\Nojimage\LocalGovCode\LocalGovCodeObjectInterface', $this->object);
        $this->assertInstanceOf('\Nojimage\LocalGovCode\LocalGovCodeObject', $this->object);
    }

    /**
     * @covers Nojimage\LocalGovCode\Ward::validate
     * @dataProvider dataValidate
     */
    public function testValidate($message, $data, $expected)
    {
        $this->assertSame($expected, Ward::validate($data), $message);
    }

    /**
     * @return array
     */
    public function dataValidate()
    {
        // @codingStandardsIgnoreStart
        return array(
            array(
                'valid data',
                array('type' => 'ward', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                true,
            ),
            array(
                'type should be `city`.',
                array('type' => 'prefecture', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required type field.',
                array('code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required code field.',
                array('type' => 'city', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required name field.',
                array('type' => 'city', 'code' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required kana field.',
                array('type' => 'city', 'code' => '', 'name' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required pref_code field.',
                array('type' => 'city', 'code' => '', 'name' => '', 'kana' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required pref_name field.',
                array('type' => 'city', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required pref_kana field.',
                array('type' => 'city', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required city_code field.',
                array('type' => 'city', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required city_name field.',
                array('type' => 'city', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required city_kana field.',
                array('type' => 'city', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'ward_code' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required ward_code field.',
                array('type' => 'city', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_name' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required ward_name field.',
                array('type' => 'city', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_kana' => ''),
                false,
            ),
            array(
                'required ward_kana field.',
                array('type' => 'city', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => '', 'city_code' => '', 'city_name' => '', 'city_kana' => '', 'ward_code' => '', 'ward_name' => ''),
                false,
            ),
        );// @codingStandardsIgnoreEnd
    }

    /**
     * Object can property access
     */
    public function testPropertyAccess()
    {
        $this->assertSame('ward', $this->object->type);
        $this->assertSame('011011', $this->object->code);
        $this->assertSame('北海道札幌市中央区', $this->object->name);
        $this->assertSame('ほっかいどうさっぽろしちゅうおうく', $this->object->kana);
        $this->assertSame('010006', $this->object->pref_code);
        $this->assertSame('北海道', $this->object->pref_name);
        $this->assertSame('ほっかいどう', $this->object->pref_kana);
        $this->assertSame('011002', $this->object->city_code);
        $this->assertSame('札幌市', $this->object->city_name);
        $this->assertSame('さっぽろし', $this->object->city_kana);
        $this->assertSame('011011', $this->object->ward_code);
        $this->assertSame('中央区', $this->object->ward_name);
        $this->assertSame('ちゅうおうく', $this->object->ward_kana);
    }

    /**
     * test for toArray
     */
    public function testToArray()
    {
        $expected = array(
            'type' => 'ward',
            'code' => '011011',
            'name' => '北海道札幌市中央区',
            'kana' => 'ほっかいどうさっぽろしちゅうおうく',
            'ward_code' => '011011',
            'ward_name' => '中央区',
            'ward_kana' => 'ちゅうおうく',
            'city_code' => '011002',
            'city_name' => '札幌市',
            'city_kana' => 'さっぽろし',
            'pref_code' => '010006',
            'pref_name' => '北海道',
            'pref_kana' => 'ほっかいどう'
        );

        $this->assertSame($expected, $this->object->toArray());
    }
}
