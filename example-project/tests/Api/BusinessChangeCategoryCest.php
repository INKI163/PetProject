<?php

namespace Api;

use Exception;
use Tests\Support\ApiTester;

require_once __DIR__ . '/../Support/Helper/UrlHelper.php';
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';

use Support\Helper\{UrlHelper, CategoryHelper};

class BusinessChangeCategoryCest
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

    /**
     * @throws Exception
     */
    public function changeDataTest(ApiTester $I): void
    {
        $expectedData = [
            'id' => 55,
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ',
        ];

        $I->sendPut(UrlHelper::CATEGORIES . '/' . $this->createdCategory, json_encode([
            'title' => 'Not Dostoevsky',
            'slug' => 'Not FQ'
        ]));

        $I->seeResponseContainsJson($expectedData);

        $I->sendGet(UrlHelper::CATEGORIES . '/' . $this->createdCategory);

        $I->seeResponseContainsJson($expectedData);
    }
}