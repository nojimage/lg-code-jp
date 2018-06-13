<?php
/**
 * JsonSerializable for PHP 5.3
 */
if (!interface_exists('\JsonSerializable')) {

    /**
     * Objects implementing JsonSerializable
     * can customize their JSON representation when encoded with
     * <b>json_encode</b>.
     * @link http://php.net/manual/en/class.jsonserializable.php
     */
    interface JsonSerializable
    {

        /**
         * (PHP 5 &gt;= 5.4.0, PHP 7)<br/>
         * Specify data which should be serialized to JSON
         * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
         * @return mixed data which can be serialized by <b>json_encode</b>,
         * which is a value of any type other than a resource.
         */
        public function jsonSerialize();
    }
}
