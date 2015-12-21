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
     * Add a message to this message bag.
     *
     * @param string $message The message to add.
     * @param string $type    The type of message to add.
     *
     * @throws  \InvalidArgumentException When the provided data is incorrect.
     * @return Bag
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

        return $this;
    }

    /**
     * Check whether this message bag has any messages.
     *
     * @return boolean Whether this bag has any messages.
     */
    public function hasMessages()
    {
        return count($this->messages) > 0;
    }

    /**
     * Get the messages from this bag
     *
     * @param string $type The type of messages to receive.
     *
     * @return array
     */
    public function getMessages($type)
    {
        if (!array_key_exists($type, $this->messages)) {
            return [];
        }
        return $this->messages[$type];
    }
}
