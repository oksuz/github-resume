<?php

namespace App\Services;

use App\Model\Developer;
use App\Model\DeveloperCv;
use App\Model\GithubRepositories;

/**
 * Class DeveloperCvBuilder
 * @package App\Services
 *
 * Cv builder keeps developer info and creates cv when you want to create
 */
class DeveloperCvBuilder
{

    private $user = null;
    private $repositories = [];
    private $developerCvInstance = null;

    /**
     * @return DeveloperCv|null
     * @throws \Exception
     */
    public function build(): DeveloperCv
    {
        if (null === $this->user) {
            throw new \Exception('user not defined');
        }

        $cv = $this->getOrCreateDeveloperCv();

        $cv->setDeveloper(new Developer($this->user));
        $cv->setRepositories(new GithubRepositories($this->repositories));

        return $cv;
    }

    public function setRepositories(array $repositories): void
    {
        $this->repositories = array_merge($this->repositories, $repositories);
    }

    public function setUser(array $userInfo): void
    {
        $this->user = $userInfo;
    }

    private function getOrCreateDeveloperCv(): DeveloperCv
    {
        if (null === $this->developerCvInstance) {
            $this->developerCvInstance = new DeveloperCv();
        }

        return $this->developerCvInstance;
    }
}