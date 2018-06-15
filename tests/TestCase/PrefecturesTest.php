<?php

namespace Nojimage\LocalGovCode\TestCase;

use Nojimage\LocalGovCode\Decorator\Collection\ArrayObjectDecorator;
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
     * Nojimage\LocalGovCode\Prefectures::createFromJson
     */
    public function testCreateFromJson()
    {
        $prefectures = Prefectures::createFromJson();

        $this->assertInstanceOf('Nojimage\LocalGovCode\Prefectures', $prefectures);
    }

    /**
     * Nojimage\LocalGovCode\Repository::getInstance
     * @todo   Implement testGetInstance().
     */
    public function testGetInstance()
    {
        $ds = $this->getMockBuilder('\Nojimage\LocalGovCode\Datasource\DatasourceInterface')->getMock();

        $prefectures = Prefectures::getInstance($ds);

        $this->assertInstanceOf('Nojimage\LocalGovCode\Prefectures', $prefectures);
    }

    /**
     * Nojimage\LocalGovCode\Repository::setDatasource
     */
    public function testSetDatasource()
    {
        $ds = $this->getMockBuilder('\Nojimage\LocalGovCode\Datasource\DatasourceInterface')->getMock();
        $this->repository->setDatasource($ds);
    }

    /**
     * Nojimage\LocalGovCode\Repository::setCollectionDecorator
     */
    public function testSetCollectionDecorator()
    {
        $results = $this->repository->findByName('東京都');
        $this->assertInternalType('array', $results);

        $this->repository->setCollectionDecorator(new ArrayObjectDecorator());

        $results = $this->repository->findByName('東京都');
        $this->assertInstanceOf('\ArrayObject', $results);
    }

    /**
     * Nojimage\LocalGovCode\Repository::setEntityDecorator
     */
    public function testSetEntityDecorator()
    {
        $decorator = $this
            ->getMockBuilder('\Nojimage\LocalGovCode\Decorator\Entity\EntityDecoratorInferface')
            ->setMethods(array('convert'))
            ->getMock();

        $decorator->expects($this->once())->method('convert')
            ->willReturn(new \stdClass());

        $this->repository->setEntityDecorator($decorator);

        $result = $this->repository->getByName('東京都');
        $this->assertInstanceOf('\stdClass', $result);
    }

    /**
     * Nojimage\LocalGovCode\Repository::get
     */
    public function testGet()
    {
        $actual = $this->repository->get('010006');

        $this->assertInstanceOf('\Nojimage\LocalGovCode\Prefecture', $actual);
        $this->assertSame('010006', $actual->code);
        $this->assertSame('北海道', $actual->name);
    }

    /**
     * Nojimage\LocalGovCode\Repository::get
     *
     * @expectedException \Nojimage\LocalGovCode\Exception\CodeNotFoundException
     * @expectedExceptionMessage The specified code can not be found.
     */
    public function testGetWithCodeNotFound()
    {
        $this->repository->get('000000');
    }

    /**
     * Nojimage\LocalGovCode\Repository::getByName
     */
    public function testGetByName()
    {
        $actual = $this->repository->getByName('北海道');

        $this->assertInstanceOf('\Nojimage\LocalGovCode\Prefecture', $actual);
        $this->assertSame('010006', $actual->code);
        $this->assertSame('北海道', $actual->name);
    }

    /**
     * Nojimage\LocalGovCode\Repository::getByName
     *
     * @expectedException \Nojimage\LocalGovCode\Exception\NameNotFoundException
     * @expectedExceptionMessage The specified name can not be found.
     */
    public function testgetByNameWithNameNotFound()
    {
        $this->repository->getByName('うどん県');
    }

    /**
     * Nojimage\LocalGovCode\Repository::getCode
     */
    public function testGetCode()
    {
        $this->assertSame('400009', $this->repository->getCode('福岡県'));
    }

    /**
     * Nojimage\LocalGovCode\Repository::getName
     */
    public function testGetName()
    {
        $this->assertSame('北海道', $this->repository->getName('010006'));
    }

    /**
     * Nojimage\LocalGovCode\Repository::isValidCode
     */
    public function testIsValidCode()
    {
        $this->assertTrue($this->repository->isValidCode('010006'));
        $this->assertFalse($this->repository->isValidCode('011002'), 'city code is not valid.');
    }

    /**
     * Nojimage\LocalGovCode\Repository::isValidName
     */
    public function testIsValidName()
    {
        $this->assertTrue($this->repository->isValidName('京都府'));
        $this->assertFalse($this->repository->isValidName('京都'));
    }

    /**
     * Nojimage\LocalGovCode\Repository::find
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
     * Nojimage\LocalGovCode\Repository::findByName
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
