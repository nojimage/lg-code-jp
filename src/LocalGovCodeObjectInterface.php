<?php

namespace Nojimage\LocalGovCode;

/**
 * Common interface
 */
interface LocalGovCodeObjectInterface extends \ArrayAccess, \Serializable, \JsonSerializable
{

    /**
     * Validate array data
     *
     * @param array $data
     * @return bool
     */
    public static function validate(array $data);

    /**
     * Get this tyoe
     *
     * @return string
     */
    public function getType();

    /**
     * Get this code
     *
     * @return string
     */
    public function getCode();

    /**
     * Get this name
     *
     * @return string
     */
    public function getName();

    /**
     * Get this kana name
     *
     * @return string
     */
    public function getKana();

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray();
}
