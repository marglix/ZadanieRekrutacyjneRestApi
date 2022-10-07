<?php

namespace App\Controller;

use App\Entity\LogoutToken;
use App\Repository\LogoutTokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogoutController extends AbstractController
{
    /**
     * @Route("/api/logout", name="app_logout", methods={"POST"})
     */
    public function logout(Request $request, LogoutTokenRepository $logoutTokenRepository): Response
    {
        $authorization = $request->headers->get("authorization");
        $token = str_replace("Bearer ", "", $authorization);
        
        $logoutToken = new LogoutToken();
        $logoutToken->setToken($token);
        $logoutTokenRepository->add($logoutToken, true);
        return $this->json(["message" => "User is logout correct"]);
    }
}
