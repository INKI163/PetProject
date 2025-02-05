<?php

namespace Api;

use Exception;
use Tests\Support\ApiTester;

require_once __DIR__ . '/../Support/Helper/UrlHelper.php';
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';

use Support\Helper\{UrlHelper, CategoryHelper};

class BusinessRemoveCategoryCest
{
    private int $createdCategory;

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

    public function removeCategoryByIdTest(ApiTester $I): void
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
        $data = json_decode($response, true);
        $I->seeResponseContainsJson($data);
    }
}