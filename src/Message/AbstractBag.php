<?php

namespace eXistenZNL\PermCheck\Message;

/**
 * The abstract class for the message bag
 *
 * @package eXistenZNL\PermCheck\Message
 */
abstract class AbstractBag implements BagInterface
{
    /**
     * The messages in this bag
     *
     * @var array
     */
    protected $messages;
}
