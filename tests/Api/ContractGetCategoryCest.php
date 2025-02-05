<?php

namespace Api;

use Exception;
use Tests\Support\ApiTester;

require_once __DIR__ . '/../Support/Helper/UrlHelper.php';
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';

use Support\Helper\{UrlHelper, CategoryHelper};

class ContractGetCategoryCest
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
    public function checkCreateNewCategoryTest(ApiTester $I): void
    {
        $I->sendGet(UrlHelper::CATEGORIES . '/' . $this->createdCategory);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getCategoryNotFoundIdTest(ApiTester $I): void
    {
        $I->sendGet(UrlHelper::CATEGORIES . '/6785');

        $I->seeResponseCodeIs(404);
    }

    public function getCategoriesByNonExistentUrlTest(ApiTester $I): void
    {
        $I->sendGet(UrlHelper::CATEGORIES . '/Lermontov');

        $I->seeResponseCodeIs(400);
    }

    public function getAllCategoriesTest(ApiTester $I): void
    {
        $I->sendGet(UrlHelper::CATEGORIES);

        $I->seeResponseCodeIs(200);
    }
}