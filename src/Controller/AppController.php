<?php


namespace App\Controller;


use App\Services\ICvCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * Class AppController
 * @package App\Controller
 *
 */
class AppController extends AbstractController
{

    /**
     * @var ICvCreator $cvCreator
     */
    protected $cvCreator;

    /**
     * AppController constructor.
     * @param ICvCreator $cvCreator
     */
    public function __construct(ICvCreator $cvCreator)
    {
        $this->cvCreator = $cvCreator;
    }

    /**
     * @param string $username
     * @param Request $request
     * @return Response
     *
     * @Route("/{username}", methods={"GET"}, defaults={"username": ""})
     */
    public function index(string $username, Request $request): Response
    {
        if (!empty($username)) {
            $cv = $this->cvCreator->createFromName($username)->getCv();
        }

        return $this->render('index.html.twig', [
            'cv' => $cv ?? null
        ]);
    }
}