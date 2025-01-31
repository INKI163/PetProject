<?php

namespace App\Controller;

use App\Entity\BookCategory;
use OpenApi\Annotations as OA;
use App\Service\BookCategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;
use Support\Helper\UrlHelper;
class BookCategoryController extends AbstractController
{
    private BookCategoryService $bookCategoryService;

    public function __construct(BookCategoryService $bookCategoryService)
    {
        $this->bookCategoryService = $bookCategoryService;
    }

    #[Route('URL_CATEGORIES/{id}', methods: ['GET'])]
    public function getCategory(int $id): JsonResponse
    {
        $category = $this->bookCategoryService->getCategoriesById($id);

        if (!$category) {
            return $this->json(['error' => 'Category not found'], 404);
        }

        return $this->json($category);
    }

    #[Route('URL_CATEGORIES/{id}', methods: ['GET'])]
    public function getCategoriesById(string $id): JsonResponse
    {
        if (!ctype_digit($id)) {

            return $this->json(['error' => 'Invalid ID format: ID must be numeric'], 400);

        }
        $categories = $this->bookCategoryService->getCategories();

        return $this->json($categories);
    }

    #[Route('URL_CATEGORIES', methods: ['GET'])]
    public function getCategories(): JsonResponse
    {
        $categories = $this->bookCategoryService->getCategories();

        return $this->json($categories);
    }

    #[Route('URL_CATEGORIES/{id}', methods: ['PUT'])]
    public function updateCategory(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $category = $this->bookCategoryService->updateCategory($id, $data);

        if (!$category) {

            return $this->json(['error' => 'Category not found'], 404);

        }

        return $this->json($category);
    }

    #[Route('URL_CATEGORIES/{id}', methods: ['DELETE'])]
    public function deleteCategory(string $id): JsonResponse
    {
        if (!ctype_digit($id)) {

            return $this->json(['error' => 'Invalid ID format: ID must be numeric'], 400);

        }

        $id = (int)$id;

        $success = $this->bookCategoryService->deleteCategory($id);

        if (!$success) {

            return $this->json(['error' => 'Category not found'], 404);

        }

        return $this->json(['message' => 'Category deleted successfully']);
    }

    #[Route('URL_CATEGORIES', methods: ['POST'])]
    public function createNewCategory(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $category = $this->bookCategoryService->createNewCategory($data['id'], $data['title'], $data['slug']);

        return $this->json([
            'id' => $category->getId(),
            'title' => $category->getTitle(),
            'slug' => $category->getSlug(),
        ], 201);
    }
}
