<?php

namespace Nojimage\LocalGovCode;

/**
 * A Prefecture
 *
 * @property-read string $pref_code
 * @property-read string $pref_name
 * @property-read string $pref_kana
 */
class Prefecture extends LocalGovCodeObject implements LocalGovCodeObjectInterface
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
    );

    /**
     * {@inheritDoc}
     */
    public static function validate(array $data)
    {
        if (!parent::validate($data)) {
            return false;
        }

        if ($data['type'] !== 'prefecture') {
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
}
