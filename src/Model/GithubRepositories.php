<?php

namespace App\Model;

class GithubRepositories implements \Iterator
{
    private $repos = [];
    private $pos = 0;

    public function __construct($repos)
    {
        $this->createGithubReposFromArray($repos);
    }

    private static function sortBy(string $getter): callable
    {
        if (!method_exists(GithubRepo::class, $getter)) {
            throw new \Exception($getter . ' getter method not available on ' . GithubRepo::class  . ' class');
        }

        return function (GithubRepo $a, GithubRepo $b) use ($getter)
        {
            return $a->$getter() > $b->$getter() ? -1 : ($a->$getter() === $b->$getter() ? 0 : 1);
        };
    }

    private function createGithubReposFromArray(array $repos): void
    {
        $this->repos = array_map(function ($repo) {
            return $this->createGithubRepoFromArray($repo);
        }, $repos);

        usort($this->repos, GithubRepositories::sortBy('getStars'));
    }

    private function createGithubRepoFromArray(array $repo): GithubRepo
    {
        return new GithubRepo($repo);
    }

    public function count(): int
    {
        return count($this->repos);
    }


    public function reposWithDeterminedLang(): array
    {
        return array_filter($this->repos, function (GithubRepo $repo) {
            return $repo->getLanguage() !== null;
        });
    }

    public function hasLanguageCount(): int
    {
        $repoWithDeterminedLang = $this->reposWithDeterminedLang();

        return count($repoWithDeterminedLang);
    }

    public function getLanguageUsageCount(): array
    {
        $languages = array_map(function (GithubRepo $repo) {
            return $repo->getLanguage();
        }, $this->reposWithDeterminedLang());


        return array_count_values($languages);
    }

    public function current()
    {
        return $this->repos[$this->pos];
    }

    public function next()
    {
        ++$this->pos;
    }

    public function key()
    {
        return $this->pos;
    }

    public function valid()
    {
        return isset($this->repos[$this->pos]);
    }

    public function rewind()
    {
        $this->pos = 0;
    }
}