<?php

namespace Api;

use Tests\Support\ApiTester;
use Support\Helper\UrlHelper;

class CreateUserCest
{
    public function updateAllCategories(ApiTester $I)
    {
        $data = [
            'id' => 1,
            'title' => 'Cat',
            'slug' => 'Dostoevsky',
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('URL_CATEGORIES', $data);

        $I->seeResponseCodeIs(201);
    }

    public function getCategories(ApiTester $I)
    {
        $I->sendGet('URL_CATEGORIES');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function updateCategory(ApiTester $I)
    {
        $I->sendPut('URL_CATEGORIES/2', json_encode([
            'title' => 'Dostoevsky',
            'slug' => 'FQ'
        ]));

        $I->seeResponseCodeIs(200);
    }

    public function getCategoriesAfterUpdate(ApiTester $I)
    {
        $I->sendGet('URL_CATEGORIES');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $I->seeResponseContainsJson($data);
    }

    public function deleteCategoryById(ApiTester $I): void
    {
        $I->sendDelete('URL_CATEGORIES/1');

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['message' => 'Category deleted successfully']);
    }

    public function getCategoriesAfterDelete(ApiTester $I)
    {
        $I->sendGet('URL_CATEGORIES');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $I->seeResponseContainsJson($data);
    }

    public function removingCategoryNonExistentId(ApiTester $I): void
    {
        $I->sendDelete('URL_CATEGORIES/999');
        $I->seeResponseCodeIs(404);
    }

    public function deleteCategoryInvalidId(ApiTester $I): void
    {
        $I->sendDelete('URL_CATEGORIES/Pushkin');

        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['error' => 'Invalid ID format: ID must be numeric']);
    }
}




