<?php

namespace Demo\Tests\Unit\Services;

use Demo\DTO\SingleManning;
use Demo\Models\Rota;

use Demo\Services\SingleManning\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_a_rota_will_return_a_shift_manning()
    {
        $subject = new Calculator();

        $rota = $this->createMock(Rota::class);
        
        //No shifts, so nothing is mapped
        $single_manning = $subject->getSingleManningData($rota);

        $this->assertInstanceOf(SingleManning::class, $single_manning);
    }
}
