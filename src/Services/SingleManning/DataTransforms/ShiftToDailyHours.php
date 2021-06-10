<?php

namespace Demo\Services\SingleManning\DataTransforms;

use Demo\Models\Shift;

class ShiftToDailyHours
{
    /**
     * Return an array hours in a day that the staff member worked
     *
     * @param Shift $shift
     * @param int $key
     *
     * @return array
     */
    public function __invoke(Shift $shift, int $key): array
    {
        $hours_worked = range(
            $shift->getFirstHourWorked(),
            $shift->getLastHourWorked()
        );
        //TODO: use factory to handle for standard or clock change days
        return [
            $shift->getDateWorked() => [
                $shift->getStaff()->getId() => $hours_worked,
            ],
        ];
    }
}
