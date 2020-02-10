<?php

namespace App\Controller;

use App\Services\GithubCvCreator;
use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController extends AbstractController
{
    public function showException(Request $request)
    {
        $exception = $request->get('exception');

        // ensure exception occurred while requesting to github
        if ($exception instanceof ClientException && strpos($exception->getRequest()->getUri(), parse_url($this->getParameter('github.url'), \PHP_URL_HOST)) !== false) {
            return $this->render('errorpage.github.html.twig', [
                'message' => $exception->getResponse()->getBody()->__toString(),
                'status' => $exception->getResponse()->getStatusCode()
            ]);
        }

        throw $exception;
    }
}