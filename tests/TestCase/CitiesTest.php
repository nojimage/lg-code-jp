<?php

namespace Nojimage\LocalGovCode\TestCase;

use Nojimage\LocalGovCode\Decorator\Collection\ArrayObjectDecorator;
use Nojimage\LocalGovCode\Cities;
use PHPUnit\Framework\TestCase;

/**
 * Test for Cities
 */
class CitiesTest extends TestCase
{

    /**
     * @var Cities
     */
    private $repository;

    /**
     * Sets up the fixture
     */
    protected function setUp()
    {
        $this->repository = Cities::createFromJson();
    }

    /**
     * Tears down the fixture
     */
    protected function tearDown()
    {
        unset($this->repository);
    }

    /**
     * @covers Nojimage\LocalGovCode\Cities::createFromJson
     */
    public function testCreateFromJson()
    {
        $prefectures = Cities::createFromJson();

        $this->assertInstanceOf('Nojimage\LocalGovCode\Cities', $prefectures);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getInstance
     * @todo   Implement testGetInstance().
     */
    public function testGetInstance()
    {
        $ds = $this->getMockBuilder('\Nojimage\LocalGovCode\Datasource\DatasourceInterface')->getMock();

        $prefectures = Cities::getInstance($ds);

        $this->assertInstanceOf('Nojimage\LocalGovCode\Cities', $prefectures);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::setDatasource
     */
    public function testSetDatasource()
    {
        $ds = $this->getMockBuilder('\Nojimage\LocalGovCode\Datasource\DatasourceInterface')->getMock();
        $this->repository->setDatasource($ds);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::setCollectionDecorator
     */
    public function testsetCollectionDecorator()
    {
        $results = $this->repository->findByName('東京都千代田区');
        $this->assertInternalType('array', $results);

        $this->repository->setCollectionDecorator(new ArrayObjectDecorator());

        $results = $this->repository->findByName('東京都千代田区');
        $this->assertInstanceOf('\ArrayObject', $results);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::get
     */
    public function testGet()
    {
        $actual = $this->repository->get('011002');

        $this->assertInstanceOf('\Nojimage\LocalGovCode\City', $actual);
        $this->assertSame('011002', $actual->code);
        $this->assertSame('北海道札幌市', $actual->name);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::get
     *
     * @expectedException \Nojimage\LocalGovCode\Exception\CodeNotFoundException
     * @expectedExceptionMessage The specified code can not be found.
     */
    public function testGetWithCodeNotFound()
    {
        $this->repository->get('000000');
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getByName
     */
    public function testGetByName()
    {
        $actual = $this->repository->getByName('北海道帯広市');

        $this->assertInstanceOf('\Nojimage\LocalGovCode\City', $actual);
        $this->assertSame('012076', $actual->code);
        $this->assertSame('北海道帯広市', $actual->name);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getByName
     *
     * @expectedException \Nojimage\LocalGovCode\Exception\NameNotFoundException
     * @expectedExceptionMessage The specified name can not be found.
     */
    public function testgetByNameWithNameNotFound()
    {
        $this->repository->getByName('香川県うどん市');
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getCode
     */
    public function testGetCode()
    {
        $this->assertSame('401307', $this->repository->getCode('福岡県福岡市'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getName
     */
    public function testGetName()
    {
        $this->assertSame('福岡県福岡市', $this->repository->getName('401307'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::isValidCode
     */
    public function testIsValidCode()
    {
        $this->assertTrue($this->repository->isValidCode('011002'));
        $this->assertFalse($this->repository->isValidCode('010006'), 'prefecture code is not valid.');
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::isValidName
     */
    public function testIsValidName()
    {
        $this->assertTrue($this->repository->isValidName('東京都渋谷区'));
        $this->assertFalse($this->repository->isValidName('東京都渋谷'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::find
     */
    public function testFind()
    {
        $actual = $this->repository->find(array('pref_kana' => 'さがけん'));

        $this->assertCount(20, $actual);
        $this->assertSame('佐賀県佐賀市', $actual[0]->name);

        // not found results
        $notFound = $this->repository->find(array('name' => '京都'));

        $this->assertCount(0, $notFound);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::findByName
     */
    public function testFindByName()
    {
        $actual = $this->repository->findByName('府中市');

        $this->assertCount(2, $actual);
        $this->assertSame('東京都府中市', $actual[0]->name);
        $this->assertSame('広島県府中市', $actual[1]->name);

        // not found results
        $notFound = $this->repository->findByName('田園都市');

        $this->assertCount(0, $notFound);
    }
}
