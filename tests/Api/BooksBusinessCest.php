<?php

namespace Api;

use App\Service\BookCategoryService;
use Codeception\Template\Api;
use Exception;
use Tests\Support\ApiTester;
use Support\Helper\UrlHelper;
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';
use Support\Helper\CategoryHelper;

class BooksBusinessCest
{
    private int $createdCategory;

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
    public function changeData(ApiTester $I): void
    {
        $I->sendPut(UrlHelper::CATEGORIES . '/' . $this->createdCategory, json_encode([
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ'
        ]));

        $I->seeResponseContainsJson([
            'id' => 55,
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ',
        ]);

        $I->sendGet(UrlHelper::CATEGORIES . '/' . $this->createdCategory);

        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $I->seeResponseContainsJson($data);
    }


    public function removeCategoryById(ApiTester $I): void
    {
        $I->sendPost(UrlHelper::CATEGORIES, json_encode([
            'id' => 56,
            'title' => 'Lermontov',
            'slug' => 'FQ'
        ]));

        $I->sendGet(UrlHelper::CATEGORIES . '/56');
        $I->seeResponseIsJson();

        $I->sendDelete(UrlHelper::CATEGORIES . '/56');

        $I->seeResponseContainsJson(['message' => 'Category deleted successfully']);

        $I->sendGet(UrlHelper::CATEGORIES);

        $response = $I->grabResponse();
        $data = json_decode($response,true);
        $I->seeResponseContainsJson($data);
    }
}
