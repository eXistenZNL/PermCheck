<?php

namespace eXistenZNL\PermCheck\Message;

/**
 * The message bag
 *
 * @package eXistenZNL\PermCheck\Message
 */
class Bag extends AbstractBag
{
    /**
     * @var array
     */
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
        if (!is_string($message)) {
            throw new \InvalidArgumentException('Message must be a string');
        }
        if (empty($message)) {
            throw new \InvalidArgumentException('Message can\'t be empty');
        }
        if (!is_string($type)) {
            throw new \InvalidArgumentException('Type must be a string');
        }
        if (empty($type)) {
            throw new \InvalidArgumentException('Type can\'t be empty');
        }
        $this->messages[$type][] = $message;
    }

    /**
     * Get the messages from this bag
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
