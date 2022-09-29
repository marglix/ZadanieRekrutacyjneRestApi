<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use App\Repository\ProductRepository;

class ApiProductController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * List of all products
     * 
     * @Route("/api/products", name="api_product", methods={"GET"})
     * 
     * @OA\Get(description="List of all products")
     * 
     * @OA\Response(
     *      response=200,
     *      description="Ok",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      description="Name of Product"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Description of Product"
     *                  )
     *              )
     *          )
     *      }
     * )
     * 
     * @OA\Tag(name="Products")
     * @Security(name="Bearer")
     */
    public function getProducts(): JsonResponse
    {
        $products = $this->productRepository->findAll();
        return $this->json($products);
    }
}
