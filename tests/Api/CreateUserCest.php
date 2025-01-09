<?php

namespace Api;

use Tests\Support\ApiTester;

class CreateUserCest
{
    public function getCategories(ApiTester $I)
    {

        $I->sendGet('/categories');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

    }

    public function updateCategory(ApiTester $I)
    {

        $I->sendPut('/categories/2', json_encode([
            'title' => 'Dostoevsky',
            'slug' => 'Double'
        ]));

        $I->seeResponseCodeIs(200);

    }

    public function getCategoriesAfterUpdate(ApiTester $I)
    {

        $I->sendGet('/categories');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $I->seeResponseContainsJson($data);

    }

    public function deleteCategoryById(ApiTester $I): void
    {

        $I->sendDelete('/categories/1');

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['message' => 'Category deleted successfully']);

    }

    public function getCategoriesAfterDelete(ApiTester $I)
    {

        $I->sendGet('/categories');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $response = $I->grabResponse();
        $data = json_decode($response, true);
        $I->seeResponseContainsJson($data);

    }
    public function removingCategoryNonExistentId(ApiTester $I): void
    {

        $I->sendDelete('/categories/999');
        $I->seeResponseCodeIs(404);

    }

    public function deleteCategoryInvalidId(ApiTester $I): void
    {

        $I->sendDelete('/categories/Pushkin');

        $I->seeResponseCodeIs(400);
        $I->seeResponseContainsJson(['error' => 'Invalid ID format: ID must be numeric']);

    }

}




