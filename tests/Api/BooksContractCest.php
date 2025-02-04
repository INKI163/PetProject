<?php

namespace Api;

use App\Service\BookCategoryService;
use Codeception\Template\Api;
use Exception;
use Tests\Support\ApiTester;
require_once __DIR__ . '/../Support/Helper/UrlHelper.php';
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';

use Support\Helper\{UrlHelper, CategoryHelper};


class BooksContractCest
{
    private ?int $createdCategory = null;


    /**
     * @throws Exception
     */
    public function _before(CategoryHelper $categoryHelper): void
    {
        $this->createdCategory =$categoryHelper->createNewCategory();
    }

    public function _after(ApiTester $I, CategoryHelper $categoryHelper): void
    {
        $categoryHelper->deleteCategory($I, $this->createdCategory);
    }

    /**
     * @throws Exception
     */
    public function checkCreateNewCategory(ApiTester $I): void
    {
        $I->sendGet(UrlHelper::CATEGORIES. '/' . $this->createdCategory);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getCategoryNotFoundId(ApiTester $I): void
    {
        $I->sendGet(UrlHelper::CATEGORIES . '/6785');

        $I->seeResponseCodeIs(404);
    }

    public function getCategoriesByNonExistentUrl(ApiTester $I): void
    {
        $I->sendGet('URL_');

        $I->seeResponseCodeIs(404);
    }

    public function getAllCategories(ApiTester $I): void
    {
        $I->sendGet(UrlHelper::CATEGORIES);

        $I->seeResponseCodeIs(200);
    }

    /**
     * @throws Exception
     */
    public function updatingCategoryWithoutIdAndCheckingTheValidityOfTheDataType(ApiTester $I): void
    {
        $I->sendPut(UrlHelper::CATEGORIES . '/' . $this->createdCategory, json_encode([
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ'
        ]));

        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $id = $data['id'];
        $title = $data['title'];
        $slug = $data['slug'];

        $I->assertIsInt($id);
        $I->assertIsString($title);
        $I->assertIsString($slug);

        $I->seeResponseCodeIs(200);
    }

    /**
     * @throws Exception
     */
    public function updateCategoryWithNotFoundCategories(ApiTester $I): void
    {
        $I->sendPut('URL_CATEG/' . $this->createdCategory, json_encode([
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ'
        ]));

        $I->seeResponseCodeIs(404);
    }


    /**
     * @throws Exception
     */
    public function removeCategoryById(ApiTester $I): void
    {
        $I->sendDelete(UrlHelper::CATEGORIES . '/' . $this->createdCategory);

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['message' => 'Category deleted successfully']);
    }

    public function removingCategoryNonExistentId(ApiTester $I): void
    {
        $I->sendDelete(UrlHelper::CATEGORIES . '/999');
        $I->seeResponseCodeIs(404);
    }

    public function removeCategoryInvalidId(ApiTester $I): void
    {
        $I->sendDelete(UrlHelper::CATEGORIES . '/Pushkin');

        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['error' => 'Invalid ID format: ID must be numeric']);
    }
}
