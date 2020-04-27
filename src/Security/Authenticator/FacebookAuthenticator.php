<?php

declare(strict_types=1);

namespace App\Security\Authenticator;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class FacebookAuthenticator extends SocialAuthenticator
{
    private $clientRegistry;
    private $router;

    public function __construct(
        ClientRegistry $clientRegistry,
        RouterInterface $router
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        return $this->router->generate('connect_facebook_check') == $request->getPathInfo() && $request->isMethod('GET');
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getFacebookClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GoogleUser $googleUser */
        $googleUser = $this->getFacebookClient()
            ->fetchUserFromToken($credentials);

        $email = $googleUser->getEmail();

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            $user = new User(
                Uuid::uuid4(),
                new EmailAddress($googleUser->getEmail()),
                (null !== $googleUser->getFirstName()) ? new PersonName($googleUser->getFirstName()) : null,
                (null !== $googleUser->getLastName()) ? new PersonName($googleUser->getLastName()) : null,
                new \DateTimeImmutable(),
                null
            );

            $this->userRepository->addNew($user);
        }

        return $user;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new RedirectResponse($this->router->generate('app_logout'));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): Response
    {
        $this->flashMessageHelper->addSuccessMessage('app.security.connection.successMessage');

        return new RedirectResponse($this->router->generate('dashboard'));
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse($this->router->generate('login'));
    }

    private function getFacebookClient(): OAuth2ClientInterface
    {
        return $this->clientRegistry->getClient('facebook');
    }
}
