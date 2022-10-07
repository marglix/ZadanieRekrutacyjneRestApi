<?php

namespace App\Controller;

use App\Entity\LogoutToken;
use App\Repository\LogoutTokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Token")
 */
class ApiTokenController extends AbstractController
{
    /**
     * User login
     * 
     * @OA\Post(description="User login")
     * 
     * @OA\RequestBody(
     *      description="User data",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="username",
     *                  type="string",
     *                  description="Username of account"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  description="Password of account"
     *              )
     *          )
     *      )
     * )
     * 
     * @OA\Response(
     *      response=200,
     *      description="Ok",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="token",
     *                      type="string",
     *                      description="Token"
     *                  ),
     *                  @OA\Property(
     *                      property="refresh_token",
     *                      type="string",
     *                      description="Refresh token"
     *                  )
     *              )
     *          )
     *      }
     * )
     * 
     * 
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function login(): Response
    {
    }

    /**
     * Refresh User token
     * 
     * @OA\Post(description="Refresh User token")
     * 
     * @OA\RequestBody(
     *      description="Refresh token",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="refresh_token",
     *                  type="string",
     *                  description="Refresh token"
     *              )
     *          )
     *      )
     * )
     * 
     * @OA\Response(
     *      response=200,
     *      description="Ok",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="token",
     *                      type="string",
     *                      description="Token"
     *                  ),
     *                  @OA\Property(
     *                      property="refresh_token",
     *                      type="string",
     *                      description="Refresh token"
     *                  )
     *              )
     *          )
     *      }
     * )
     * 
     * 
     * @Route("/api/token/refresh", name="api_refresh_token", methods={"POST"})
     */
    public function refreshToken(): Response
    {
    }

    /**
     * Token logout
     * 
     * @Route("/api/logout", name="app_logout", methods={"POST"})
     * 
     * @OA\Post(description="Token logout")
     * 
     * @Security(name="Bearer")
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
