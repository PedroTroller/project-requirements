<?php

namespace Knp\ProjectRequirements\DependencyInjection;

use ArrayAccess;
use Knp\ProjectRequirements\DependencyInjection\Container\Exception\ServiceNotFound;

class Container implements ArrayAccess
{
    /** @var callable[]; */
    private $builders = [];

    /** @var array */
    private $shareds = [];

    /**
     * @return string[]
     */
    public function getKeys()
    {
        $keys = array_merge(
            array_keys($this->builders),
            array_keys($this->shareds)
        );

        sort($keys);

        return array_unique($keys);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->builders) || array_key_exists($offset, $this->shareds);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if (array_key_exists($offset, $this->shareds)) {
            return $this->shareds[$offset];
        }

        if (array_key_exists($offset, $this->builders)) {
            return $this->shareds[$offset] = $this->builders[$offset]($this);
        }

        throw new ServiceNotFound($offset, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            $this->offsetUnset($offset);
        }

        if (is_callable($value)) {
            $this->builders[$offset] = $value;

            return;
        }

        $this->shareds[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if (array_key_exists($offset, $this->shareds)) {
            unset($this->shareds[$offset]);
        }

        if (array_key_exists($offset, $this->builders)) {
            unset($this->builders[$offset]);
        }
    }
}
