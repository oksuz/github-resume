<?php

namespace App\Model;

/**
 * Class GithubRepositories
 * @package App\Model
 *
 * Delegates repo iteration and contains info with user's repositories (counts etc.)
 */
class GithubRepositories implements \Iterator
{
    private $repos = [];
    private $pos = 0;

    public function __construct($repos)
    {
        $this->createGithubReposFromArray($repos);
    }

    /**
     * @param string $getter
     * @return callable
     * @throws \Exception
     *
     * generates sort callback by getter method, default sorting is descending
     *
     * @TODO maybe we can add sorting direction support to this method
     */
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


    /**
     * @param array $repos
     * @throws \Exception
     *
     * creates GithubRepo and sorts (by stars) @var $repos, from array
     */
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


    /**
     * @return int
     *
     * some repositories language cannot determined. that gives count of repos which is determined language
     */
    public function hasLanguageCount(): int
    {
        $repoWithDeterminedLang = $this->reposWithDeterminedLang();

        return count($repoWithDeterminedLang);
    }

    /**
     * @return array, array<lang = count>
     */
    public function getLanguageUsageCount(): array
    {
        $languages = array_map(function (GithubRepo $repo) {
            return $repo->getLanguage();
        }, $this->reposWithDeterminedLang());


        return array_count_values($languages);
    }

    public function current(): GithubRepo
    {
        return $this->repos[$this->pos];
    }

    public function next(): void
    {
        ++$this->pos;
    }

    public function key(): int
    {
        return $this->pos;
    }

    public function valid(): bool
    {
        return isset($this->repos[$this->pos]);
    }

    public function rewind(): void
    {
        $this->pos = 0;
    }
}