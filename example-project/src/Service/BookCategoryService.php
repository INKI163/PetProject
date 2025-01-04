<?php

namespace App\Service;

use App\Entity\BookCategory;
use App\Model\BookCategoryListItem;
use App\Model\BookCategoryListResponse;
use App\Repository\BookCategoryRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;

class BookCategoryService
{
    private EntityManagerInterface $entityManager;

    public function __construct(private BookCategoryRepository $bookCategoryRepository, EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;

    }
    public function getCategories(): BookCategoryListResponse
    {

        $categories=$this->bookCategoryRepository->findBy([], ['title'=> Criteria::ASC]);
        $items = array_map(
            fn (BookCategory $bookCategory) => new BookCategoryListItem(

                $bookCategory->getId(),
                $bookCategory->getTitle(),
                $bookCategory->getSlug()

            ),

            $categories

        );

        return new BookCategoryListResponse($items);

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
}
