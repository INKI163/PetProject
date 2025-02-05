<?php

namespace Api;

use Exception;
use Tests\Support\ApiTester;

require_once __DIR__ . '/../Support/Helper/UrlHelper.php';
require_once __DIR__ . '/../Support/Helper/CategoryHelper.php';

use Support\Helper\{UrlHelper, CategoryHelper};

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

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['message' => 'Category deleted successfully']);
    }

    public function removeCategoryNonExistentIdTest(ApiTester $I): void
    {
        $I->sendDelete(UrlHelper::CATEGORIES . '/999');
        $I->seeResponseCodeIs(404);
    }

    public function removeCategoryInvalidIdTest(ApiTester $I): void
    {
        $I->sendDelete(UrlHelper::CATEGORIES . '/Pushkin');

        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['error' => 'Invalid ID format: ID must be numeric']);
    }
}