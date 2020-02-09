<?php


namespace App\Controller;


use GuzzleHttp\Exception\ClientException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController extends AbstractController
{
    public function showException(Request $request)
    {
        $exception = $request->get('exception');
        if ($exception instanceof ClientException) {
            return $this->render('errorpage.github.html.twig', [
                'message' => $exception->getResponse()->getBody()->__toString()
            ]);
        }

        throw $exception;
    }
}