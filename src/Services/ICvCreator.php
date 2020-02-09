<?php


namespace App\Services;


use App\Model\DeveloperCv;

interface ICvCreator
{
    function createFromName(string $name): ICvCreator;

    function getCv(): ?DeveloperCv;
}