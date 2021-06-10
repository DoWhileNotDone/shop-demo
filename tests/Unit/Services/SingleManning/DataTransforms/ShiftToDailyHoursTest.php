<?php

namespace Demo\Tests\Unit\Services\ShiftManning\DataTransforms;

use Demo\DTO\SingleManning;

use Demo\Models\Rota;
use Demo\Models\Shift;
use Demo\Models\Staff;
use Demo\Services\SingleManning\DataTransforms\ShiftToDailyHours;
use PHPUnit\Framework\TestCase;

class ShiftToDailyHoursTest extends TestCase
{
    /**
     * @dataProvider shift_hours
     *
     * @return void
     */
    public function test_a_shift_hours_worked_are_correct(
        \DateTime $start_date,
        \DateTime $end_date,
        int $hours_worked,
        array $expected_outcome
    ): void {
        $staff = $this->createMock(Staff::class);
        $staff->expects($this->once())
            ->method('getId')
            ->willReturn('Staff Member');

        $shift = new Shift(
            $this->createMock(Rota::class),
            $staff,
            $start_date,
            $end_date,
        );

        $subject = new ShiftToDailyHours();

        $result = call_user_func($subject, $shift, 0);

        $this->assertTrue(
            array_key_exists(
                $shift->getDateWorked(),
                $result,
            )
        );

        $this->assertTrue(
            array_key_exists(
                'Staff Member',
                $result[$shift->getDateWorked()],
            )
        );

        $hours_result = $result[$shift->getDateWorked()]['Staff Member'];

        $this->assertEquals(
            $hours_result,
            $expected_outcome
        );

        $this->assertEquals(
            $hours_worked,
            count($hours_result)
        );
    }

    /**
     *
     * @return array
     */
    public function shift_hours(): array
    {
        return [
            'Today, starting at midnight, finishing at 5am, 5 hours' => [
                (new \DateTime())->modify("today +0 hour"),
                (new \DateTime())->modify("today +5 hour"),
                5,
                [0, 1, 2, 3, 4],
            ],
            'Today, starting at 9pm, finishing at midnight, 3 hours' => [
                (new \DateTime())->modify("today +21 hour"),
                (new \DateTime())->modify("today +24 hour"),
                3,
                [21, 22, 23],
            ],
            'Today, starting at 9am, finishing at 1pm, 4 hours' => [
                (new \DateTime())->modify("today +9 hour"),
                (new \DateTime())->modify("today +13 hour"),
                4,
                [9, 10, 11, 12],
            ],
            'Today, starting at midnight, finishing at 1am, 1 hours' => [
                (new \DateTime())->modify("today "),
                (new \DateTime())->modify("today +1 hour"),
                1,
                [0],
            ],
        ];
    }
}
