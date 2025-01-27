<?php

namespace Support\Helper;

use Exception;
use Tests\Support\ApiTester;

class MethodsHelper
{
    public int $createdCategory;

    /**
     * @throws Exception
     */
    public function createNewCategory(ApiTester $I): int
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('URL_CATEGORIES',json_encode([
            'id' => 55,
            'title' => 'Pushkin',
            'slug' => 'FQ'
        ]));

        $I->seeResponseCodeIs(201);

        $this->createdCategory = $I->grabDataFromResponseByJsonPath('$.id')[0];

        return $this->createdCategory;
    }
}