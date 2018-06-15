<?php

namespace Nojimage\LocalGovCode\TestCase;

use Nojimage\LocalGovCode\Decorator\Collection\ArrayObjectDecorator;
use Nojimage\LocalGovCode\Wards;
use PHPUnit\Framework\TestCase;

/**
 * Test for Wards
 */
class WardsTest extends TestCase
{

    /**
     * @var Wards
     */
    private $repository;

    /**
     * Sets up the fixture
     */
    protected function setUp()
    {
        $this->repository = Wards::createFromJson();
    }

    /**
     * Tears down the fixture
     */
    protected function tearDown()
    {
        unset($this->repository);
    }

    /**
     * @covers Nojimage\LocalGovCode\Wards::createFromJson
     */
    public function testCreateFromJson()
    {
        $prefectures = Wards::createFromJson();

        $this->assertInstanceOf('Nojimage\LocalGovCode\Wards', $prefectures);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getInstance
     * @todo   Implement testGetInstance().
     */
    public function testGetInstance()
    {
        $ds = $this->getMockBuilder('\Nojimage\LocalGovCode\Datasource\DatasourceInterface')->getMock();

        $prefectures = Wards::getInstance($ds);

        $this->assertInstanceOf('Nojimage\LocalGovCode\Wards', $prefectures);
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
        $results = $this->repository->findByName('北海道札幌市中央区');
        $this->assertInternalType('array', $results);

        $this->repository->setCollectionDecorator(new ArrayObjectDecorator());

        $results = $this->repository->findByName('北海道札幌市中央区');
        $this->assertInstanceOf('\ArrayObject', $results);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::get
     */
    public function testGet()
    {
        $actual = $this->repository->get('011011');

        $this->assertInstanceOf('\Nojimage\LocalGovCode\Ward', $actual);
        $this->assertSame('011011', $actual->code);
        $this->assertSame('北海道札幌市中央区', $actual->name);
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
        $actual = $this->repository->getByName('北海道札幌市中央区');

        $this->assertInstanceOf('\Nojimage\LocalGovCode\Ward', $actual);
        $this->assertSame('011011', $actual->code);
        $this->assertSame('北海道札幌市中央区', $actual->name);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getByName
     *
     * @expectedException \Nojimage\LocalGovCode\Exception\NameNotFoundException
     * @expectedExceptionMessage The specified name can not be found.
     */
    public function testgetByNameWithNameNotFound()
    {
        $this->repository->getByName('福岡県福岡市長浜区');
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getCode
     */
    public function testGetCode()
    {
        $this->assertSame('401323', $this->repository->getCode('福岡県福岡市博多区'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getName
     */
    public function testGetName()
    {
        $this->assertSame('福岡県福岡市博多区', $this->repository->getName('401323'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::isValidCode
     */
    public function testIsValidCode()
    {
        $this->assertTrue($this->repository->isValidCode('011011'));
        $this->assertFalse($this->repository->isValidCode('010006'), 'prefecture code is not valid.');
        $this->assertFalse($this->repository->isValidCode('011002'), 'city code is not valid.');
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::isValidName
     */
    public function testIsValidName()
    {
        $this->assertTrue($this->repository->isValidName('福岡県福岡市博多区'));
        $this->assertFalse($this->repository->isValidName('福岡県福岡市博多'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::find
     */
    public function testFind()
    {
        $actual = $this->repository->find(array('pref_kana' => 'ふくおかけん'));

        $this->assertCount(14, $actual);
        $this->assertSame('福岡県北九州市門司区', $actual[0]->name);

        // not found results
        $notFound = $this->repository->find(array('name' => '京都'));

        $this->assertCount(0, $notFound);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::findByName
     */
    public function testFindByName()
    {
        $actual = $this->repository->findByName('西区');

        $this->assertCount(12, $actual);
        $this->assertSame('北海道札幌市西区', $actual[0]->name);

        // not found results
        $notFound = $this->repository->findByName('うどん区');

        $this->assertCount(0, $notFound);
    }
}
