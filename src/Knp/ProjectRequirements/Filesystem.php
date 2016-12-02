<?php

namespace Knp\ProjectRequirements;

interface Filesystem
{
    const FORMAT_JSON = 'json';
    const FORMAT_TEXT = 'text';

    /**
     * @param string $path
     *
     * @return bool
     */
    public function exists($path);

    /**
     * @param string $path
     * @param string $format
     *
     * @return mixed
     */
    public function read($path, $format = self::FORMAT_TEXT);

    /**
     * @param string $path
     * @param mixed  $data
     * @param string $format
     */
    public function write($path, $data, $format = self::FORMAT_TEXT);
}
