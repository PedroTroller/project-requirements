<?php

namespace Knp\ProjectRequirements\Github;

class InformationProvider
{
    /** @var string */
    private $remote;

    /** @var array */
    private $information;

    /**
     * @param string $remote
     */
    public function __construct($remote)
    {
        $this->remote = $remote;
    }

    /**
     * {@inheritdoc}
     */
    public function getSource()
    {
        $informations = $this->extractInformation();

        return $informations['source'];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganisation()
    {
        $informations = $this->extractInformation();

        return $informations['organisation'];
    }

    /**
     * {@inheritdoc}
     */
    public function getProject()
    {
        $informations = $this->extractInformation();

        return $informations['project'];
    }

    /**
     * @return array
     */
    private function extractInformation()
    {
        if (null !== $this->information) {
            return $this->information;
        }

        $matches = [];

        switch (1) {
            case preg_match('/^git@(\w+)\.com:(.+)\/(.+)\.git$/', $this->remote, $matches):
                list($remote, $source, $organisation, $project) = $matches;

                return $this->informations = [
                    'source'       => $source,
                    'organisation' => $organisation,
                    'project'      => $project,
                ];
            case preg_match('/^https:\/\/(\w+)\.com\/(.+)\/(.+)\.git$/', $this->remote, $matches):
                list($remote, $source, $organisation, $project) = $matches;

                return $this->informations = [
                    'source'       => $source,
                    'organisation' => $organisation,
                    'project'      => $project,
                ];
        }
    }
}
