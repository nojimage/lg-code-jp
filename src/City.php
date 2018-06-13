<?php

namespace Nojimage\LocalGovCode;

/**
 * A City
 *
 * @property-read string $pref_code
 * @property-read string $pref_name
 * @property-read string $pref_kana
 * @property-read string $city_code
 * @property-read string $city_name
 * @property-read string $city_kana
 */
class City extends LocalGovCodeObject implements LocalGovCodeObjectInterface
{

    /**
     * @var array
     */
    protected static $requiredFields = array(
        'type',
        'code',
        'name',
        'kana',
        'pref_code',
        'pref_name',
        'pref_kana',
        'city_code',
        'city_name',
        'city_kana',
    );

    /**
     * {@inheritDoc}
     */
    public static function validate(array $data)
    {
        if (!parent::validate($data)) {
            return false;
        }

        if ($data['type'] !== 'city') {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getPrefCode()
    {
        return $this->properties['pref_code'];
    }

    /**
     * @return string
     */
    public function getPrefName()
    {
        return $this->properties['pref_name'];
    }

    /**
     * @return string
     */
    public function getPrefKana()
    {
        return $this->properties['pref_kana'];
    }

    /**
     * @return string
     */
    public function getCityCode()
    {
        return $this->properties['city_code'];
    }

    /**
     * @return string
     */
    public function getCityName()
    {
        return $this->properties['city_name'];
    }

    /**
     * @return string
     */
    public function getCityKana()
    {
        return $this->properties['city_kana'];
    }
}
