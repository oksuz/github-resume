<?php

namespace App\Tests\Services;

use App\Services\DeveloperCvBuilder;
use PHPUnit\Framework\TestCase;

class DeveloperCvBuilderTest extends TestCase
{

    public function testBuildException()
    {
        $instance = new DeveloperCvBuilder();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('user not defined');

        $instance->build();
    }

    public function testBuild()
    {
        $instance = new DeveloperCvBuilder();

        $user = json_decode(file_get_contents(__DIR__ . '/user.json'), true);
        $repos = json_decode(file_get_contents(__DIR__ . '/repos.json'), true);

        $instance->setUser($user);
        $instance->setRepositories($repos);
        $cv1 = $instance->build();
        $cv2 = $instance->build();

        $this->assertEquals($cv1, $cv2);
    }

}
