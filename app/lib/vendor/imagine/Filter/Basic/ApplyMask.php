<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\vendor\imagine\Filter\Basic;

use lib\vendor\imagine\Filter\FilterInterface;
use lib\vendor\imagine\Image\ImageInterface;

/**
 * An apply mask filter
 */
class ApplyMask implements FilterInterface
{
    /**
     * @var ImageInterface
     */
    private $mask;

    /**
     * @param ImageInterface $mask
     */
    public function __construct(ImageInterface $mask)
    {
        $this->mask = $mask;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(ImageInterface $image)
    {
        return $image->applyMask($this->mask);
    }
}
