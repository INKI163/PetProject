<?php

declare(strict_types=1);

namespace Tests\Support;
use PHPUnit\Framework\Assert;

/**
 * Inherited Methods
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])

 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;
    public function assertIsArray(string $value): void
    {
        Assert::assertIsArray($value);
    }

    public function assertIsString(string $value): void
    {
        Assert::assertIsString($value);
    }

    public function assertIsInt(mixed $id): void
    {
        Assert::assertIsInt($id);
    }
}
