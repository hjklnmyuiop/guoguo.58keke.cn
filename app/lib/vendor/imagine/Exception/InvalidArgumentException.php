<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\vendor\imagine\Exception;

use InvalidArgumentException as BaseInvalidArgumentException;

/**
 * Imagine-specific invalid argument exception
 */
class InvalidArgumentException extends BaseInvalidArgumentException implements Exception
{
}
