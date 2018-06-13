<?php

namespace Nojimage\LocalGovCode;

use InvalidArgumentException;
use LogicException;
use RuntimeException;

/**
 * LocalGovCodeObject
 *
 * @property-read string $type
 * @property-read string $code
 * @property-read string $name
 * @property-read string $kana
 */
class LocalGovCodeObject implements LocalGovCodeObjectInterface
{

    /**
     * @var array
     */
    protected $properties = array();

    /**
     * @var array
     */
    protected static $requiredFields = array(
        'type',
        'code',
        'name',
        'kana'
    );

    /**
     * @param array $data
     * @throws InvalidArgumentException
     */
    public function __construct(array $data)
    {
        if (!static::validate($data)) {
            throw new InvalidArgumentException('Invalid data structure.');
        }

        $this->properties = $data;
    }

    /**
     * {@inheritDoc}
     */
    public static function validate(array $data)
    {
        foreach (static::$requiredFields as $required) {
            if (!isset($data[$required])) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getCode()
    {
        return $this->properties['code'];
    }

    /**
     * {@inheritDoc}
     */
    public function getKana()
    {
        return $this->properties['kana'];
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->properties['name'];
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return $this->properties['type'];
    }

    /**
     * @param string $name
     * @return mixed
     * @throws LogicException
     */
    public function __get($name)
    {
        $methodName = 'get' . static::camelize($name);

        if (method_exists($this, $methodName)) {
            return call_user_func(array($this, $methodName));
        }

        throw new LogicException(sprintf('%s::%s is not implemented.', __CLASS__, $methodName));
    }

    /**
     * Camelized name
     *
     * @param string $name
     * @return string
     */
    protected function camelize($name)
    {
        $parts = explode('_', $name);

        return implode('', array_map('ucfirst', $parts));
    }

    /**
     * {@inheritDoc}
     */
    public function __set($name, $value)
    {
        // read only
        throw new LogicException(__CLASS__ . ' is read only.');
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->properties[$offset]);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->properties[$offset];
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        throw new LogicException(__CLASS__ . ' is read only.');
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        throw new LogicException(__CLASS__ . ' is read only.');
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->properties;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return json_encode($this->properties, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $properties = json_decode($serialized, true);

        if (json_last_error()) {
            throw new RuntimeException('Unable unserialize: ' . json_last_error_msg());
        }

        $this->properties = $properties;
    }
}
