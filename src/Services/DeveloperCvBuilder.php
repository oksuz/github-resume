<?php


namespace App\Services;


use App\Model\DeveloperCv;

class DeveloperCvBuilder
{

    private $user;
    private $repositories;

    public function build(): ?DeveloperCv
    {
    }

    public function setRepositories(array $repositories)
    {
        $this->repositories = $repositories;
    }

    public function setUser(array $userInfo): void
    {
        $this->user = $userInfo;
    }
}