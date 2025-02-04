<?php

namespace Support\Helper;

use Tests\Support\ApiTester;

use Support\Helper\CategoryHelper;

class DeleteCategoryHelper
{
    public function deleteCategory(ApiTester $I, int $categoryId): mixed
    {
        $this->deleteCategorys = $I->sendDelete(UrlHelper::CATEGORIES . '/' . $categoryId);

        return $this->deleteCategorys;
    }
}