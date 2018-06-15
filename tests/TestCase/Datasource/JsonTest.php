<?php

namespace Nojimage\LocalGovCode\TestCase\Datasource;

use PHPUnit\Framework\TestCase;
use Nojimage\LocalGovCode\Datasource\Json;

/**
 * Test for Json
 */
class JsonTest extends TestCase
{

    /**
     * @var Json
     */
    private $datasource;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->datasource = new Json('prefectures.json');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->datasource);
    }

    /**
     * test for getFilepath
     */
    public function testGetFilepath()
    {
        $root = dirname(dirname(dirname(__DIR__)));
        // @codingStandardsIgnoreStart
        $expected = $root . '/vendor/nojimage/local-gov-code-jp/prefectures.json';// @codingStandardsIgnoreEnd

        $this->assertSame($expected, $this->datasource->getFilepath());
    }

    /**
     * Test construct with absolute file path
     */
    public function testCreateWithAbsoluteFilepath()
    {
        $filepath = $expected = TEST_DIR . '/Fixture/data.json';

        $ds = new Json($filepath);

        $this->assertSame($expected, $ds->getFilepath());
    }

    /**
     * Test construct with relative file path
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage File not found: ../../Fixture/data.json
     */
    public function testCreateWithRelativeFilepath()
    {
        $filepath = '../../Fixture/data.json';
        $expected = TEST_DIR . '/Fixture/data.json';

        $ds = new Json($filepath);

        $this->assertSame($expected, $ds->getFilepath());
    }

    /**
     * @covers Nojimage\LocalGovCode\Datasource\Json::findByCode
     */
    public function testFindByCode()
    {
        $expected = array(
            'type' => 'prefecture',
            'code' => '130001',
            'name' => '東京都',
            'kana' => 'とうきょうと',
            'pref_code' => '130001',
            'pref_name' => '東京都',
            'pref_kana' => 'とうきょうと',
        );

        $this->assertSame($expected, $this->datasource->findByCode('130001'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Datasource\Json::findByName
     */
    public function testFindByName()
    {
        $expected = array(
            'type' => 'prefecture',
            'code' => '130001',
            'name' => '東京都',
            'kana' => 'とうきょうと',
            'pref_code' => '130001',
            'pref_name' => '東京都',
            'pref_kana' => 'とうきょうと',
        );

        $this->assertSame($expected, $this->datasource->findByName('東京都'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Datasource\Json::find
     */
    public function testFind()
    {
        $datasource = new Json(Json::CITIES_JSON);
        $conditions = array(
            'pref_name' => '東京都',
        );
        $result = $datasource->find($conditions);

        $expectedCount = 62;
        $expected = array(
            'type' => 'city',
            'code' => '131016',
            'name' => '東京都千代田区',
            'kana' => 'とうきょうとちよだく',
            'city_code' => '131016',
            'city_name' => '千代田区',
            'city_kana' => 'ちよだく',
            'pref_code' => '130001',
            'pref_name' => '東京都',
            'pref_kana' => 'とうきょうと'
        );

        $this->assertCount($expectedCount, $result);
        $this->assertSame($expected, $result[0]);
    }

    /**
     * @covers Nojimage\LocalGovCode\Datasource\Json::find
     */
    public function testFindNotExists()
    {
        $datasource = new Json(Json::CITIES_JSON);
        $conditions = array(
            'pref_name' => 'notexists',
        );
        $result = $datasource->find($conditions);

        $this->assertSame(array(), $result);
    }
}
