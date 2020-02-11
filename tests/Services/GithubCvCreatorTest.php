<?php

namespace App\Tests\Services;

use App\Services\DeveloperCvBuilder;
use App\Services\GithubClient;
use App\Services\GithubCvCreator;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class GithubCvCreatorTest extends TestCase
{

    use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testCreateFromName()
    {
        $client = \Mockery::spy(GithubClient::class);
        $builder = \Mockery::spy(DeveloperCvBuilder::class);
        $logger = \Mockery::spy(LoggerInterface::class);
        $userResponse = \Mockery::mock(Response::class);
        $reposResponse = \Mockery::mock(Response::class);

        $user = file_get_contents(__DIR__ . '/user.json');
        $repos = file_get_contents(__DIR__ . '/repos.json');

        $userResponse->shouldReceive('getBody')->andReturn($user);
        $reposResponse->shouldReceive('getBody')->andReturn($repos);
        $reposResponse->shouldReceive('getHeader')->with('Link')->andReturn([]);

        $client->shouldReceive('get')->with('/users/oksuz')->andReturn($userResponse);
        $client->shouldReceive('get')->with("https://api.github.com/users/oksuz/repos", \Mockery::any())->andReturn($reposResponse);

        $service = new GithubCvCreator($client, $builder, $logger);

        $service->createFromName("oksuz");

        $builder->shouldHaveReceived('setUser');
        $builder->shouldHaveReceived('setRepositories');
    }



}
