<?php

namespace Nojimage\LocalGovCode\Exception;

/**
 * Name not found exception
 */
class NameNotFoundException extends \RuntimeException
{

    protected $message = 'The specified name can not be found.';
}
