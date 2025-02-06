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
        $I->sendDelete(UrlHelper::CATEGORIES . '/' . $this->createdCategory);

        $I->seeResponseContainsJson(['message' => 'Category deleted successfully']);

        $I->sendGet(UrlHelper::CATEGORIES);

        $I->seeResponseContainsJson([]);

    }
}