<?php

namespace Knp\ProjectRequirements\Filesystem;

class Local extends Base
{
    /** @var string */
    private $root;

    /**
     * @param string $root
     */
    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($path)
    {
        return file_exists($this->buildFullPath($path));
    }

    /**
     * {@inheritdoc}
     */
    public function read($path, $format = self::FORMAT_TEXT)
    {
        $data = file_get_contents($this->buildFullPath($path));

        return $this->toData($data, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function write($path, $data, $format = self::FORMAT_TEXT)
    {
        $data = $this->toText($data, $format);

        file_put_contents($this->buildFullPath($path), $data);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function buildFullPath($path)
    {
        return sprintf(
            '%s%s%s',
            rtrim($this->root, DIRECTORY_SEPARATOR),
            DIRECTORY_SEPARATOR,
            ltrim($path, DIRECTORY_SEPARATOR)
        );
    }
}
