<?php

namespace Api;

use Exception;
use Tests\Support\ApiTester;

require_once __DIR__ . '/../Support/Helper/UrlHelper.php';
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';

use Support\Helper\{UrlHelper, CategoryHelper};

class BusinessGetCategoryCest
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

    public function getAllCategoriesTest(ApiTester $I): void
    {
        $I->sendGet(UrlHelper::CATEGORIES);

        $I->seeResponseCodeIs(200);

        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $I->seeResponseContainsJson($data);
    }
}