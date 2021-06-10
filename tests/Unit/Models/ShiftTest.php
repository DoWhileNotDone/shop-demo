<?php

namespace Demo\Tests\Unit\Models;

use Demo\Models\Rota;
use Demo\Models\Shift;
use Demo\Models\Shop;
use Demo\Models\Staff;

use PHPUnit\Framework\TestCase;

class ShiftTest extends TestCase
{

    /**
     *
     * @return void
     */
    public function test_a_shift_will_be_added_to_the_rota(): void
    {
        $shop = new Shop('shop_name');

        $rota = new Rota(
            new \DateTime(),
            $shop,
        );

        $this->assertEquals(
            0,
            count($rota->getShifts())
        );

        $shift = new Shift(
            $rota,
            new Staff(
                'Jim',
                'Jam',
                $shop,
            ),
            new \DateTime(),
            new \DateTime(),
        );

        $this->assertEquals(
            1,
            count($rota->getShifts())
        );

        $this->assertEquals(
            $shift,
            (new \ArrayIterator($rota->getShifts()))->current(),
        );
    }

    /**
     * @dataProvider shift_dates
     *
     * @return void
     */
    public function test_a_shift_date_is_calculated_correct(\DateTime $start_date, string $expected_date): void
    {
        $shift = new Shift(
            $this->createMock(Rota::class),
            $this->createMock(Staff::class),
            $start_date,
            new \DateTime(),
        );

        $this->assertEquals(
            $shift->getDateWorked(),
            $expected_date
        );
    }

    /**
     *
     * @return array
     */
    public function shift_dates(): array
    {
        $date = new \DateTime();

        return [
            'Today, starting at midnight' => [
                $date,
                $date->format('Y-m-d'),
            ],
        ];
    }
}
