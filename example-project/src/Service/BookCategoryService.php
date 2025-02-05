<?php

namespace App\Service;

use App\Entity\BookCategory;
use App\Model\BookCategoryListItem;
use App\Model\BookCategoryListResponse;
use App\Repository\BookCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookCategoryService
{
    private EntityManagerInterface $entityManager;

    public function __construct(private BookCategoryRepository $bookCategoryRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCategories(): BookCategoryListResponse
    {
        $categories = $this->bookCategoryRepository->findBy([]);
        $items = array_map(
            fn(BookCategory $bookCategory) => new BookCategoryListItem(

                $bookCategory->getId(),
                $bookCategory->getTitle(),
                $bookCategory->getSlug()
            ),

            $categories

        );

        return new BookCategoryListResponse($items);
    }

    public function getCategoriesById(int $id): ?array
    {
        $category = $this->bookCategoryRepository->find($id);

        if ($category === null) {

            return null;

        }

        return [
            'id' => $category->getId(),
            'title' => $category->getTitle(),
            'slug' => $category->getSlug()
        ];
    }

    public function updateCategory(int $id, array $data): ?BookCategory
    {
        $category = $this->bookCategoryRepository->find($id);

        if (!$category) {

            return null;

        }

        if (isset($data['title'])) {

            $category->setTitle($data['title']);

        }

        if (isset($data['slug'])) {

            $category->setSlug($data['slug']);

        }

        $this->entityManager->flush();

        return $category;
    }

    public function deleteCategory(int $id): bool
    {
        $category = $this->bookCategoryRepository->find($id);

        if (!$category) {

            return false;

        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return true;
    }

    public function createNewCategory(int $id, string $title, string $slug): BookCategory
    {
        $category = new BookCategory();
        $category->setId($id);
        $category->setTitle($title);
        $category->setSlug($slug);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }
}
