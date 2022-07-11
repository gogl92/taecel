<?php

namespace Taecel\Taecel\Tests\Unit;

use Taecel\Taecel\Taecel;
use Taecel\Taecel\Tests\TestCase;

class TaecelTest extends TestCase
{

    public function testGetBalance()
    {
        $repository = Taecel::create();
        $this->assertNotNull($repository);
        $response = $repository->getBalance();
        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
    }

}