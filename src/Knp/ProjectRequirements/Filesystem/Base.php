<?php

namespace Knp\ProjectRequirements\Filesystem;

use Knp\ProjectRequirements\Filesystem;

abstract class Base implements Filesystem
{
    /**
     * @param string $text
     * @param string $format
     *
     * @return mixed
     */
    protected function toData($text, $format)
    {
        switch ($format) {
            case Filesystem::FORMAT_JSON:
                return $this->transformToJson($text);
            case Filesystem::FORMAT_TEXT:
                return $this->transformToText($text);
        }

        return $text;
    }

    /**
     * @param mixed  $data
     * @param string $format
     *
     * @return string
     */
    protected function toText($data, $format)
    {
        return $this->transformToText($data);
    }

    /**
     * @param string|array $json
     *
     * @return string
     */
    private function transformToText($json)
    {
        if (is_string($json)) {
            return $json;
        }

        return json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param string $text
     *
     * @return string|array
     */
    private function transformToJson($text)
    {
        return json_decode($text, true);
    }
}
