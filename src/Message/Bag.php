<?php

namespace eXistenZNL\PermCheck\Message;

/**
 * The message bag
 *
 * @package eXistenZNL\PermCheck\Message
 */
class Bag extends AbstractBag
{
    protected $messages;

    /**
     * Check whether this message bag has any messages
     *
     * @return boolean
     */
    public function hasMessages()
    {
        return count($this->messages) > 0;
    }

    /**
     * Add a message to this message bag
     *
     * @param string $message The message to add
     * @param string $type    One of the
     */
    public function addMessage($message, $type)
    {
        $this->messages[$type][] = $message;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
