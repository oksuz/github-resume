<?php

namespace App\Controller;

use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ExceptionController
 * @package App\Controller
 *
 * Handles GithubClient exception for notice to user about rate limit or not existing github user
 */
class ExceptionController extends AbstractController
{
    public function showException(Request $request)
    {
        $exception = $request->get('exception');

        if ($exception instanceof ClientException) {
            // ensure exception occurred while requesting to github
            $targetHost = $exception->getRequest()->getUri()->getHost();
            $githubApiHost = parse_url($this->getParameter('github.url'), \PHP_URL_HOST);

            if ($targetHost === $githubApiHost) {
                return $this->render('errorpage.github.html.twig', [
                    'message' => $exception->getResponse()->getBody()->__toString(),
                    'status' => $exception->getResponse()->getStatusCode()
                ]);
            }
        }

        throw $exception;
    }
}