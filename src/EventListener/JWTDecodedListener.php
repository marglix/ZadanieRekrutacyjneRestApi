<?php

namespace App\EventListener;

use App\Repository\LogoutTokenRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTDecodedListener 
{
    private RequestStack $requestStack;

    private LogoutTokenRepository $logoutTokenRepository;

    public function __construct(RequestStack $requestStack, LogoutTokenRepository $logoutTokenRepository)
    {
        $this->requestStack = $requestStack;
        $this->logoutTokenRepository = $logoutTokenRepository;
    }

    public function onJWTDecoded(JWTDecodedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $authorization = $request->headers->get("authorization");
        $token = str_replace("Bearer ", "", $authorization);

        $logoutTokensEntity = $this->logoutTokenRepository->findAll();
        $logoutTokens = array_map(function($entity){ 
            return $entity->getToken(); 
        }, $logoutTokensEntity);

        if (in_array($token, $logoutTokens)) {
            $event->markAsInvalid();
        }
    }
}