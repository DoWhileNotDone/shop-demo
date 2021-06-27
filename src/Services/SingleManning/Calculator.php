<?php

namespace Demo\Services\SingleManning;

use Demo\DTO\SingleManning;
use Demo\Models\Rota;
use Demo\Services\SingleManning\DataTransforms\DailyHoursToDailySingleMinutes;
use Demo\Services\SingleManning\DataTransforms\ShiftToDailyHours;

class Calculator
{
    /**
     * Run the steps on the supplied rota
     * Return the data in the required format
     *
     * @param Rota $rota
     * @return SingleManning
     */
    public function getSingleManningData(Rota $rota): SingleManning
    {
        $steps = [
            new ShiftToDailyHours(),
            new DailyHoursToDailySingleMinutes(),
        ];

        $data = $rota->getShifts();
        
        foreach ($steps as $step) {
            $mapped = [];
            foreach ($data as $key => $map_item) {
                $mapped = array_merge_recursive(
                    $mapped,
                    call_user_func($step, $map_item, $key),
                );
            }
            $data = $mapped;
        }
        return new SingleManning($data);
    }
}
