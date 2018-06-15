<?php

namespace Nojimage\LocalGovCode\TestCase;

use LogicException;
use Nojimage\LocalGovCode\LocalGovCodeObject;
use PHPUnit\Framework\TestCase;

/**
 * test for LocalGovCodeObject
 */
class LocalGovCodeObjectTest extends TestCase
{

    /**
     * @var LocalGovCodeObject
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new LocalGovCodeObject(array(
            'type' => 'region',
            'code' => '123456',
            'name' => 'テスト地域',
            'kana' => 'てすとちいき',
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
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::validate
     * @dataProvider dataValidate
     */
    public function testValidate($message, $data, $expected)
    {
        $this->assertSame($expected, LocalGovCodeObject::validate($data), $message);
    }

    /**
     * @return array
     */
    public function dataValidate()
    {
        return array(
            array(
                'valid data',
                array('type' => '', 'code' => '', 'name' => '', 'kana' => ''),
                true,
            ),
            array(
                'required type field.',
                array('code' => '', 'name' => '', 'kana' => ''),
                false,
            ),
            array(
                'required code field.',
                array('type' => '', 'name' => '', 'kana' => ''),
                false,
            ),
            array(
                'required name field.',
                array('type' => '', 'code' => '', 'kana' => ''),
                false,
            ),
            array(
                'required kana field.',
                array('type' => '', 'code' => '', 'name' => ''),
                false,
            ),
        );
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::getCode
     */
    public function testGetCode()
    {
        $this->assertSame('123456', $this->object->getCode());
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::getKana
     */
    public function testGetKana()
    {
        $this->assertSame('てすとちいき', $this->object->getKana());
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::getName
     */
    public function testGetName()
    {
        $this->assertSame('テスト地域', $this->object->getName());
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::getType
     */
    public function testGetType()
    {
        $this->assertSame('region', $this->object->getType());
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::jsonSerialize
     */
    public function testJsonSerialize()
    {
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            $this->markTestSkipped('require PHP>=5.4');
        }

        // @codingStandardsIgnoreStart
        $expected = '{"type":"region","code":"123456","name":"\u30c6\u30b9\u30c8\u5730\u57df","kana":"\u3066\u3059\u3068\u3061\u3044\u304d"}';// @codingStandardsIgnoreEnd
        $result = json_encode($this->object);

        $this->assertJson($result);
        $this->assertSame($expected, $result);
    }

    /**
     * Object can property access
     */
    public function testPropertyAccess()
    {
        $this->assertSame('region', $this->object->type);
        $this->assertSame('123456', $this->object->code);
        $this->assertSame('テスト地域', $this->object->name);
        $this->assertSame('てすとちいき', $this->object->kana);
    }

    /**
     * Object can't property access when get method not implemented
     *
     * @expectedException LogicException
     * @expectedExceptionMessage Nojimage\LocalGovCode\LocalGovCodeObject::getInvalid is not implemented.
     */
    public function testInvalidPropertyAccess()
    {
        $this->object->invalid;
    }

    /**
     * Object can array access
     */
    public function testArrayAccess()
    {
        $this->assertSame(true, isset($this->object['code']));
        $this->assertSame(false, isset($this->object['empty']));
        $this->assertSame('123456', $this->object['code']);
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::offsetSet
     * @expectedException LogicException
     * @expectedExceptionMessage LocalGovCodeObject is read only.
     */
    public function testOffsetSet()
    {
        $this->object['code'] = '654321';
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::offsetUnset
     * @expectedException LogicException
     * @expectedExceptionMessage LocalGovCodeObject is read only.
     */
    public function testOffsetUnset()
    {
        unset($this->object['code']);
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::__set
     * @expectedException LogicException
     * @expectedExceptionMessage LocalGovCodeObject is read only.
     */
    public function testReadOnlyObject()
    {
        $this->object->code = '654321';
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::toArray
     */
    public function testToArray()
    {
        $expected = array(
            'type' => 'region',
            'code' => '123456',
            'name' => 'テスト地域',
            'kana' => 'てすとちいき',
        );

        $this->assertSame($expected, $this->object->toArray());
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::serialize
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::unserialize
     */
    public function testSerialize()
    {
        $expected = array(
            'type' => 'region',
            'code' => '123456',
            'name' => 'テスト地域',
            'kana' => 'てすとちいき',
        );
        $unserialized = unserialize(serialize($this->object));

        $this->assertSame($expected, $unserialized->toArray());
    }

    /**
     * @covers Nojimage\LocalGovCode\LocalGovCodeObject::camelize
     */
    public function testCamelize()
    {
        $this->assertSame('Name', LocalGovCodeObject::camelize('name'));
        $this->assertSame('PrefName', LocalGovCodeObject::camelize('pref_name'));
        $this->assertSame('VariableName', LocalGovCodeObject::camelize('variable__name'));
    }
}
