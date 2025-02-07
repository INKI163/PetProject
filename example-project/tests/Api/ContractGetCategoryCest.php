<?php

namespace Api;

use Exception;
use Tests\Support\ApiTester;

require_once __DIR__ . '/../Support/Helper/UrlHelper.php';
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';
require_once __DIR__ . '/../Support/Helper/HttpCodeHelper.php';

use Support\Helper\{HttpCodeHelper, UrlHelper, CategoryHelper};

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

        $I->seeResponseCodeIs(HttpCodeHelper::OK);
    }

    public function getCategoryNotExistentIdTest(ApiTester $I): void
    {
        $notExistentId = '6785';

        $I->sendGet(UrlHelper::CATEGORIES . '/' . $notExistentId);

        $I->seeResponseCodeIs(HttpCodeHelper::PAGE_NOT_FOUND);
    }

    public function getCategoriesByNonExistentUrlTest(ApiTester $I): void
    {
        $invalidId = 'Lermontov';

        $I->sendGet(UrlHelper::CATEGORIES . '/' . $invalidId);

        $I->seeResponseCodeIs(HttpCodeHelper::BAD_REQUEST);
    }

    public function getAllCategoriesTest(ApiTester $I): void
    {
        $I->sendGet(UrlHelper::CATEGORIES);

        $I->seeResponseCodeIs(HttpCodeHelper::OK);
    }
}