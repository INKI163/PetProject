<?php

namespace Api;


use App\Service\BookCategoryService;
use Exception;
use Tests\Support\ApiTester;
use Support\Helper\UrlHelper;
require_once __DIR__ . '/../Support/Helper/MethodsHelper.php';
use Support\Helper\MethodsHelper;

class CreateUserCest
{
    private int $createdCategory;
    private MethodsHelper $methodsHelper;

    /**
     * @throws Exception
     */
    public function _before(ApiTester $I): void
    {
        $this->methodsHelper = new MethodsHelper();

        $this->createdCategory = $this->methodsHelper->createNewCategory($I);
    }

    public function _after(ApiTester $I): void
    {
        $I->sendDelete('URL_CATEGORIES/' . $this->createdCategory);
    }

    /**
     * @throws Exception
     */
    public function getCategories(ApiTester $I): void
    {
        $I->sendGet('URL_CATEGORIES/' . $this->createdCategory);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $I->seeResponseContainsJson($data);
    }

    /**
     * @throws Exception
     */
    public function updateCategory(ApiTester $I): void
    {
        $I->sendPut('URL_CATEGORIES/' . $this->createdCategory, json_encode([
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ'
        ]));

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
    public function deleteCategoryById(ApiTester $I): void
    {
        $I->sendDelete('URL_CATEGORIES/' . $this->createdCategory);

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['message' => 'Category deleted successfully']);
    }

    public function removingCategoryNonExistentId(ApiTester $I): void
    {
        $I->sendDelete('URL_CATEGORIES/999');
        $I->seeResponseCodeIs(404);
    }

    public function deleteCategoryInvalidId(ApiTester $I): void
    {
        $I->sendDelete('URL_CATEGORIES/Pushkin');

        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['error' => 'Invalid ID format: ID must be numeric']);
    }
}