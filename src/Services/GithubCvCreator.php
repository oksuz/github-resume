<?php

namespace App\Services;

use App\Model\DeveloperCv;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GithubCvCreator implements ICvCreator
{

    const API_URL = 'https://api.github.com';

    /**
     * @var Client
     */
    protected $guzzle;

    /**
     * @var DeveloperCvBuilder $cvBuilder
     */
    protected $cvBuilder;

    public function __construct(Client $guzzle, DeveloperCvBuilder $builder)
    {
        $this->guzzle = $guzzle;
        $this->cvBuilder = $builder;
    }

    public function setConfig(array $config) {
        /**
         * @TODO implement this if github token is required
         */
    }

    public function createFromName(string $username): ICvCreator
    {
        $this->cvBuilder->setUser($this->getUser($username));
        $this->cvBuilder->setRepositories($this->getRepositories($username));
    }

    public function getCv(): ?DeveloperCv
    {
        return $this->cvBuilder->build();
    }

    private function getUser(string $username): array
    {
        $response = $this->guzzle->get(sprintf("%s/users/%s", self::API_URL, $username));
        return json_decode($response->getBody(), true);
    }

    private function getRepositories(string $username, $page = 1, $perPage = 10, array $collector = [])
    {
        $response = $this->guzzle->get(sprintf("%s/users/%s/repos", self::API_URL, $username), [
            'query' => [
                'page' => $page,
                'per_page' => $perPage
            ]
        ]);

        $repos = array_merge($collector, json_decode($response->getBody(), true));

        if (!empty($response->getHeader('Link'))) {
            return $this->getRepositories($username, ++$page, $perPage, $repos);
        }

        return $repos;
    }

}