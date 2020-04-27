<?php

declare(strict_types=1);

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment as Twig;

final class SecuritySignIn extends AbstractController
{
    private $clientRegistry;
    private $renderer;

    public function __construct(ClientRegistry $clientRegistry, Twig $renderer)
    {
        $this->clientRegistry = $clientRegistry;
        $this->renderer = $renderer;
    }

    /**
     * @Route("/login", name="login", methods={"GET"})
     */
    public function loginAction()
    {
        return new Response($this->renderer->render('security/login.html.twig'));
    }

    /**
     * @Route("/sign_in_with_google", name="sign_in_with_google", methods={"GET"})
     */
    public function googleAction(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect();
    }


    /**
     * @Route("/sign_in_with_facebook", name="sign_in_with_facebook", methods={"GET"})
     */
    public function facebookAction(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry
            ->getClient('facebook')
            ->redirect();
    }
}
