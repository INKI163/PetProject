<?php

namespace Api;

use Exception;
use Tests\Support\ApiTester;

require_once __DIR__ . '/../Support/Helper/UrlHelper.php';
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';
require_once __DIR__ . '/../Support/Helper/HttpCodeHelper.php';

use Support\Helper\{UrlHelper, CategoryHelper, HttpCodeHelper};

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

        $I->seeResponseCodeIs(HttpCodeHelper::OK);

        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $id = $data['id'];
        $title = $data['title'];
        $slug = $data['slug'];

        $I->assertIsInt($id);
        $I->assertIsString($title);
        $I->assertIsString($slug);

        $I->seeResponseCodeIs(HttpCodeHelper::OK);
    }

    /**
     * @throws Exception
     */
    public function updateCategoryWithNotFoundCategoriesByIDTest(ApiTester $I): void
    {
        $notExistentId = '5675';

        $I->sendPut(UrlHelper::CATEGORIES . '/' . $notExistentId, json_encode([
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ'
        ]));

        $I->seeResponseCodeIs(HttpCodeHelper::PAGE_NOT_FOUND);
    }

    public function updateCategoryWithInvalidQueryDataTest(ApiTester $I): void
    {
        $invalidQuery = 'Lermontov';

        $I->sendPut(UrlHelper::CATEGORIES . '/' . $invalidQuery, json_encode([
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ'
        ]));

        $I->seeResponseCodeIs(HttpCodeHelper::BAD_REQUEST);
    }
}