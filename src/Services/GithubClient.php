<?php


namespace App\Services;
use GuzzleHttp\Client;

/**
 * Class GithubClient
 * @package App\Services
 *
 * pre configured github http api client
 */
class GithubClient extends Client
{

    public function __construct(array $config = [])
    {
        if (!empty($config['headers']) && !empty($config['headers']['Authorization'])) {
            $config['headers']['Authorization'] = sprintf('token %s', $config['headers']['Authorization']);
        }

        parent::__construct($config);
    }

}