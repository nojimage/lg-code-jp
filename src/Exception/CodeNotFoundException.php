<?php

namespace Nojimage\LocalGovCode\Exception;

/**
 * Code not found exception
 */
class CodeNotFoundException extends \RuntimeException
{

    protected $message = 'The specified code can not be found.';
}
