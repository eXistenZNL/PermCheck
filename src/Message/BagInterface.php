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
     * Add a message to this message bag.
     *
     * @param string $message The message to add.
     * @param string $type    The type of message to add.
     *
     * @throws  \InvalidArgumentException When the provided data is incorrect.
     * @return Bag
     */
    public function addMessage($message, $type);

    /**
     * Check whether this message bag has any messages
     *
     * @return boolean
     */
    public function hasMessages();

    /**
     * Get the messages from this bag
     *
     * @param string $type The type of messages to receive.
     *
     * @return array
     */
    public function getMessages($type);
}
