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

    public function getCategoriesByIdTest(ApiTester $I): void
    {
        $expectedData = [
            'id' => 55,
            'title' => 'Pushkin',
            'slug' => 'FQ'
        ];

        $I->seeResponseContainsJson($expectedData);

        $I->sendGet(UrlHelper::CATEGORIES . '/' . $this->createdCategory);

        $I->seeResponseCodeIs(200);

        $I->seeResponseContainsJson($expectedData);
    }
}