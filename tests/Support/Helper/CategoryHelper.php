<?php

namespace Support\Helper;

use Exception;
use Tests\Support\ApiTester;

class CategoryHelper
{
    public ?int $createdCategory = null;

    private ApiTester $I;

    public function _inject(ApiTester $I): void
    {
        $this->I = $I;
    }

    /**
     * @throws Exception
     */
    public function createNewCategory(): int
    {
        $I = $this->I;

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost(UrlHelper::CATEGORIES, json_encode([
            'id' => 55,
            'title' => 'Pushkin',
            'slug' => 'FQ'
        ]));

        $I->seeResponseCodeIs(201);

        $this->createdCategory = $I->grabDataFromResponseByJsonPath('$.id')[0];

        return $this->createdCategory;
    }

    public function deleteCategory(ApiTester $I, int $categoryId): void
    {
        $I->sendDelete(UrlHelper::CATEGORIES . '/' . $categoryId);
    }
}