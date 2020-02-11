<?php


namespace App\Model;

/**
 * Class Developer
 * @package App\Model
 *
 * Developer model keeps developer information
 */
class Developer
{
    private $fullName;
    private $githubUserName;
    private $blog;
    private $repoCount;
    private $avatarUrl;
    private $location;

    public function __construct(array $userInfo)
    {
        $this->setFullName($userInfo['name'])
            ->setAvatarUrl($userInfo['avatar_url'])
            ->setBlog($userInfo['blog'])
            ->setGithubUserName($userInfo['login'])
            ->setLocation($userInfo['location'])
            ->setRepoCount($userInfo['public_repos']);
    }


    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): Developer
    {
        $this->fullName = $fullName;
        return $this;
    }


    public function getGithubUserName(): string
    {
        return $this->githubUserName;
    }


    public function setGithubUserName(string $githubUserName): Developer
    {
        $this->githubUserName = $githubUserName;
        return $this;
    }


    public function getBlog(): ?string
    {
        return $this->blog;
    }

    public function setBlog(string $blog): Developer
    {
        $this->blog = $blog;
        return $this;
    }

    public function getRepoCount(): int
    {
        return $this->repoCount;
    }

    public function setRepoCount(int $repoCount): Developer
    {
        $this->repoCount = $repoCount;
        return $this;
    }


    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(string $avatarUrl): Developer
    {
        $this->avatarUrl = $avatarUrl;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): Developer
    {
        $this->location = $location;
        return $this;
    }

}