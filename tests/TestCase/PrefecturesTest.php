<?php

namespace Nojimage\LocalGovCode\TestCase;

use Nojimage\LocalGovCode\Collection\ArrayObjectProvider;
use Nojimage\LocalGovCode\Prefectures;
use PHPUnit\Framework\TestCase;

/**
 * Test for Prefectures
 */
class PrefecturesTest extends TestCase
{

    /**
     * @var Prefectures
     */
    private $repository;

    /**
     * Sets up the fixture
     */
    protected function setUp()
    {
        $this->repository = Prefectures::createFromJson();
    }

    /**
     * Tears down the fixture
     */
    protected function tearDown()
    {
        unset($this->repository);
    }

    /**
     * @covers Nojimage\LocalGovCode\Prefectures::createFromJson
     */
    public function testCreateFromJson()
    {
        $prefectures = Prefectures::createFromJson();

        $this->assertInstanceOf('Nojimage\LocalGovCode\Prefectures', $prefectures);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getInstance
     * @todo   Implement testGetInstance().
     */
    public function testGetInstance()
    {
        $ds = $this->getMockBuilder('\Nojimage\LocalGovCode\Datasource\DatasourceInterface')->getMock();

        $prefectures = Prefectures::getInstance($ds);

        $this->assertInstanceOf('Nojimage\LocalGovCode\Prefectures', $prefectures);
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
     * @covers Nojimage\LocalGovCode\Repository::setCollectionProvider
     */
    public function testSetCollectionProvider()
    {
        $results = $this->repository->findByName('東京都');
        $this->assertInternalType('array', $results);

        $this->repository->setCollectionProvider(new ArrayObjectProvider());

        $results = $this->repository->findByName('東京都');
        $this->assertInstanceOf('\ArrayObject', $results);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::get
     */
    public function testGet()
    {
        $actual = $this->repository->get('010006');

        $this->assertInstanceOf('\Nojimage\LocalGovCode\Prefecture', $actual);
        $this->assertSame('010006', $actual->code);
        $this->assertSame('北海道', $actual->name);
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
        $actual = $this->repository->getByName('北海道');

        $this->assertInstanceOf('\Nojimage\LocalGovCode\Prefecture', $actual);
        $this->assertSame('010006', $actual->code);
        $this->assertSame('北海道', $actual->name);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getByName
     *
     * @expectedException \Nojimage\LocalGovCode\Exception\NameNotFoundException
     * @expectedExceptionMessage The specified name can not be found.
     */
    public function testgetByNameWithNameNotFound()
    {
        $this->repository->getByName('うどん県');
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getCode
     */
    public function testGetCode()
    {
        $this->assertSame('400009', $this->repository->getCode('福岡県'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::getName
     */
    public function testGetName()
    {
        $this->assertSame('北海道', $this->repository->getName('010006'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::isValidCode
     */
    public function testIsValidCode()
    {
        $this->assertTrue($this->repository->isValidCode('010006'));
        $this->assertFalse($this->repository->isValidCode('011002'), 'city code is not valid.');
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::isValidName
     */
    public function testIsValidName()
    {
        $this->assertTrue($this->repository->isValidName('京都府'));
        $this->assertFalse($this->repository->isValidName('京都'));
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::find
     */
    public function testFind()
    {
        $actual = $this->repository->find(array('pref_kana' => 'さがけん'));

        $this->assertCount(1, $actual);
        $this->assertSame('佐賀県', $actual[0]->name);

        // not found results
        $notFound = $this->repository->find(array('name' => '京都'));

        $this->assertCount(0, $notFound);
    }

    /**
     * @covers Nojimage\LocalGovCode\Repository::findByName
     */
    public function testFindByName()
    {
        $actual = $this->repository->findByName('島根県');

        $this->assertCount(1, $actual);
        $this->assertSame('島根県', $actual[0]->name);

        // not found results
        $notFound = $this->repository->findByName('鳥島県');

        $this->assertCount(0, $notFound);
    }
}