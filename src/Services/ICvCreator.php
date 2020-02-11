<?php


namespace App\Services;


use App\Model\DeveloperCv;

/**
 * Interface ICvCreator
 * @package App\Services
 *
 * For injecting another implementation of CvCreator to any service or controller
 * @see: config/service.yml
 */
interface ICvCreator
{
    function createFromName(string $name): ICvCreator;

    function getCv(): ?DeveloperCv;
}