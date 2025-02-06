<?php

namespace Api;

use Exception;
use Tests\Support\ApiTester;

require_once __DIR__ . '/../Support/Helper/UrlHelper.php';
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';
require_once __DIR__ . '/../Support/Helper/HttpCodeHelper.php';

use Support\Helper\{HttpCodeHelper, UrlHelper, CategoryHelper};

class ContractRemoveCategoryCest
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
    public function removeCategoryByIdTest(ApiTester $I): void
    {
        $I->sendDelete(UrlHelper::CATEGORIES . '/' . $this->createdCategory);

        $I->seeResponseCodeIs(HttpCodeHelper::OK);
        $I->seeResponseContainsJson(['message' => 'Category deleted successfully']);
    }

    public function removeCategoryNonExistentIdTest(ApiTester $I): void
    {
        $notExistentId = '999';

        $I->sendDelete(UrlHelper::CATEGORIES . '/' . $notExistentId);
        $I->seeResponseCodeIs(HttpCodeHelper::PAGE_NOT_FOUND);
    }

    public function removeCategoryInvalidIdTest(ApiTester $I): void
    {
        $invalidId = 'Pushkin';
        $I->sendDelete(UrlHelper::CATEGORIES . '/' . $invalidId);

        $I->seeResponseCodeIs(HttpCodeHelper::BAD_REQUEST);
        $I->seeResponseContainsJson(['error' => 'Invalid ID format: ID must be numeric']);
    }
}