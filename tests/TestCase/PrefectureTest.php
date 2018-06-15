<?php

namespace Nojimage\LocalGovCode\TestCase;

use Nojimage\LocalGovCode\Prefecture;
use PHPUnit\Framework\TestCase;

/**
 * test for Prefecture
 */
class PrefectureTest extends TestCase
{

    /**
     * @var Prefecture
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Prefecture(array(
            'type' => 'prefecture',
            'code' => '010006',
            'name' => '北海道',
            'kana' => 'ほっかいどう',
            'pref_code' => '010006',
            'pref_name' => '北海道',
            'pref_kana' => 'ほっかいどう',
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
     * Nojimage\LocalGovCode\Prefecture::validate
     * @dataProvider dataValidate
     */
    public function testValidate($message, $data, $expected)
    {
        $this->assertSame($expected, Prefecture::validate($data), $message);
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
                array('type' => 'prefecture', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => ''),
                true,
            ),
            array(
                'type should be `prefecture`.',
                array('type' => 'city', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => ''),
                false,
            ),
            array(
                'required type field.',
                array('code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => ''),
                false,
            ),
            array(
                'required code field.',
                array('type' => 'prefecture', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => ''),
                false,
            ),
            array(
                'required name field.',
                array('type' => 'prefecture', 'code' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => ''),
                false,
            ),
            array(
                'required kana field.',
                array('type' => 'prefecture', 'code' => '', 'name' => '', 'pref_code' => '', 'pref_name' => '', 'pref_kana' => ''),
                false,
            ),
            array(
                'required pref_code field.',
                array('type' => 'prefecture', 'code' => '', 'name' => '', 'kana' => '', 'pref_name' => '', 'pref_kana' => ''),
                false,
            ),
            array(
                'required pref_name field.',
                array('type' => 'prefecture', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_kana' => ''),
                false,
            ),
            array(
                'required pref_kana field.',
                array('type' => 'prefecture', 'code' => '', 'name' => '', 'kana' => '', 'pref_code' => '', 'pref_name' => ''),
                false,
            ),
        );// @codingStandardsIgnoreEnd
    }

    /**
     * Object can property access
     */
    public function testPropertyAccess()
    {
        $this->assertSame('prefecture', $this->object->type);
        $this->assertSame('010006', $this->object->code);
        $this->assertSame('北海道', $this->object->name);
        $this->assertSame('ほっかいどう', $this->object->kana);
        $this->assertSame('010006', $this->object->pref_code);
        $this->assertSame('北海道', $this->object->pref_name);
        $this->assertSame('ほっかいどう', $this->object->pref_kana);
    }

    /**
     * test for toArray
     */
    public function testToArray()
    {
        $expected = array(
            'type' => 'prefecture',
            'code' => '010006',
            'name' => '北海道',
            'kana' => 'ほっかいどう',
            'pref_code' => '010006',
            'pref_name' => '北海道',
            'pref_kana' => 'ほっかいどう',
        );

        $this->assertSame($expected, $this->object->toArray());
    }
}
