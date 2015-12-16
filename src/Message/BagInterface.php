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

    /**
     * Add a message to this message bag
     *
     * @param string $message The message to add
     * @param string $type    One of the
     */
    public function addMessage($message, $type);

    /**
     * Get the messages from this bag
     *
     * @param $type The type of messages to receive
     *
     * @return array
     */
    public function getMessages($type);
}
