<?php

namespace App\Services;

use App\Model\DeveloperCv;
use Psr\Log\LoggerInterface;

/**
 * Class GithubCvCreator
 * @package App\Services
 *
 * takes info from github api, that is actual bridge of the controller and models
 */
class GithubCvCreator implements ICvCreator
{
    /**
     * @var GithubClient
     */
    protected $guzzle;

    /**
     * @var DeveloperCvBuilder
     */
    protected $cvBuilder;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(GithubClient $guzzle, DeveloperCvBuilder $builder, LoggerInterface $logger)
    {
        $this->guzzle = $guzzle;
        $this->cvBuilder = $builder;
        $this->logger = $logger;
    }

    public function createFromName(string $username): ICvCreator
    {
        $user = $this->getUser($username);
        $this->cvBuilder->setUser($user);
        $this->cvBuilder->setRepositories($this->getRepositories($user['repos_url']));
        return $this;
    }

    public function getCv(): ?DeveloperCv
    {
        return $this->cvBuilder->build();
    }

    /**
     * @param string $username
     * @return array
     *
     * get user info from github
     */
    private function getUser(string $username): array
    {
        $response = $this->guzzle->get(sprintf("/users/%s",  $username));
        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $repoUrl
     * @param int $page
     * @param int $perPage
     * @param array $collector, for recursive calls
     * @return array
     *
     * takes user repositories, if user have more than $perPage repositories, it starts recursive call until fetching all repositories;.
     */
    private function getRepositories(string $repoUrl, $page = 1, $perPage = 100, array $collector = []): array
    {
        $options = [
            'query' => [
                'page' => $page,
                'per_page' => $perPage
            ]
        ];

        $this->logger->debug('requesting to ' . $repoUrl . ' with params', $options);

        $response = $this->guzzle->get($repoUrl, $options);

        $repos = json_decode($response->getBody(), true);
        $collector = array_merge($collector, $repos);

        if (!empty($response->getHeader('Link')) && !empty($repos)) {
            return $this->getRepositories($repoUrl, ++$page, $perPage, $collector);
        }

        return $collector;
    }
}