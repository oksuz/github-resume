<?php


namespace App\Model;

/**
 * Class DeveloperCv
 * @package App\Model
 *
 * Keeps Developer and him/her's repositories with calculation helper methods
 */
class DeveloperCv
{
    /**
     * @var Developer
     */
    private $developer;

    /**
     * @var GithubRepositories
     */
    private $repositories;

    public function setDeveloper(Developer $developer): void
    {
        $this->developer = $developer;
    }

    public function setRepositories(GithubRepositories $repositories): void
    {
        $this->repositories = $repositories;
    }

    /**
     * @return Developer
     */
    public function getDeveloper(): Developer
    {
        return $this->developer;
    }

    /**
     * @return GithubRepositories
     */
    public function getRepositories(): GithubRepositories
    {
        return $this->repositories;
    }

    /**
     * @return array, array<[lang => [count, percentage]>
     * calculates language using percent by repository count
     * languages sorted descending by language using count
     */
    public function getLanguages(): array
    {
        $totalCount = $this->repositories->hasLanguageCount();
        $counts = $this->repositories->getLanguageUsageCount();

        $reposByLangPercentage = array_reduce(array_keys($counts), function (array $accumulator, string $language) use ($counts, $totalCount) {
            $accumulator[$language] = [
                'percentage' => $counts[$language] * 100 / $totalCount,
                'count' => $counts[$language]
            ];

            return $accumulator;
        }, []);


        uksort($reposByLangPercentage, function (string $key1, string $key2) use ($reposByLangPercentage) {
            return $reposByLangPercentage[$key1]['count'] > $reposByLangPercentage[$key2]['count']
                ? -1
                : ($reposByLangPercentage[$key1]['count'] === $reposByLangPercentage[$key2]['count'] ? 0 : 1);
        });

        return $reposByLangPercentage;
    }


}