<?php

namespace Nojimage\LocalGovCode\TestCase\Decorator\Entity;

use PHPUnit\Framework\TestCase;
use Nojimage\LocalGovCode\Decorator\Entity\DefaultEntityDecorator;

/**
 * test for DefaultEntityDecorator
 */
class DefaultEntityDecoratorTest extends TestCase
{

    /**
     * @covers Nojimage\LocalGovCode\Decorator\Entity\DefaultEntityDecorator::convert
     */
    public function testConvert()
    {
        $decorator = new DefaultEntityDecorator();

        $pref = array(
            'type' => 'prefecture',
            'code' => '010006',
            'name' => '北海道',
            'kana' => 'ほっかいどう',
            'pref_code' => '010006',
            'pref_name' => '北海道',
            'pref_kana' => 'ほっかいどう',
        );
        $city = array(
            'type' => 'city',
            'code' => '011002',
            'name' => '北海道札幌市',
            'kana' => 'ほっかいどうさっぽろし',
            'city_code' => '011002',
            'city_name' => '札幌市',
            'city_kana' => 'さっぽろし',
            'pref_code' => '010006',
            'pref_name' => '北海道',
            'pref_kana' => 'ほっかいどう'
        );
        $ward = array(
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
        $region = array(
            'type' => 'region',
            'code' => '02',
            'name' => '東北',
            'kana' => 'とうほく',
        );

        $this->assertInstanceOf('\Nojimage\LocalGovCode\Prefecture', $decorator->convert($pref));
        $this->assertInstanceOf('\Nojimage\LocalGovCode\City', $decorator->convert($city));
        $this->assertInstanceOf('\Nojimage\LocalGovCode\Ward', $decorator->convert($ward));
        $this->assertInstanceOf('\Nojimage\LocalGovCode\LocalGovCodeObject', $decorator->convert($region));
    }
}
