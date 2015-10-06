<?php

namespace eXistenZNL\PermCheck\Message;

/**
 * The interface for the message bag
 *
 * @package eXistenZNL\PermCheck\Message
 */
interface BagInterface
{
    /**
     * Check whether this message bag has any messages
     *
     * @return boolean
     */
    public function hasMessages();
}
