<?php

namespace Api;

use Exception;
use Tests\Support\ApiTester;

require_once __DIR__ . '/../Support/Helper/UrlHelper.php';
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';

use Support\Helper\{UrlHelper, CategoryHelper};

class ContractChangeCategoryCest
{
    private ?int $createdCategory = null;

    /**
     * @throws Exception
     */
    public function _before(CategoryHelper $categoryHelper): void
    {
        $this->createdCategory = $categoryHelper->createNewCategory();
    }

    public function _after(CategoryHelper $categoryHelper): void
    {
        $categoryHelper->deleteCategory($this->createdCategory);
    }

    /**
     * @throws Exception
     */
    public function updatingCategoryIdAndCheckingDataTypeTest(ApiTester $I): void
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
    public function updateCategoryWithNotFoundCategoriesByIDTest(ApiTester $I): void
    {
        $I->sendPut(UrlHelper::CATEGORIES . '/5675', json_encode([
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ'
        ]));

        $I->seeResponseCodeIs(404);
    }

    public function updateCategoryWithNotFoundCategoriesDataTypeTest(ApiTester $I): void
    {
        $I->sendPut(UrlHelper::CATEGORIES . '/Lermontov', json_encode([
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ'
        ]));

        $I->seeResponseCodeIs(400);
    }
}