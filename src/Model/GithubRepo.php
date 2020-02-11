<?php


namespace App\Model;

/**
 * Class GithubRepo
 * @package App\Model
 *
 * keeps github repo info
 */
class GithubRepo
{
    private $stars = 0;
    private $language;
    private $url;
    private $name;
    private $description;

    public function __construct(array $repo)
    {
        $this->setLanguage($repo['language'])
            ->setStars((int) $repo['stargazers_count'])
            ->setUrl($repo['html_url'])
            ->setName($repo['name'])
            ->setDescription($repo['description']);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl($url): GithubRepo
    {
        $this->url = $url;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function setName($name): GithubRepo
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }


    public function setDescription(?string $description): GithubRepo
    {
        $this->description = $description;
        return $this;
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function setStars(int $stars): GithubRepo
    {
        $this->stars = $stars;
        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): GithubRepo
    {
        $this->language = $language;
        return $this;
    }



}