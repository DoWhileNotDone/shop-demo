<?php

namespace Demo\Utils;

use Demo\Services\SingleManning\DataTransforms\DailyHoursToDailySingleMinutes;
use Demo\Services\SingleManning\DataTransforms\ShiftToDailyHours;

class RunTransform
{
    use TransformArrayMapper;

    public function __construct(
        //TODO: Make into interface/callable type
        private ShiftToDailyHours|DailyHoursToDailySingleMinutes $transform,
    ) {}

    public function __invoke(array $items): array
    {
        return $this->iterate(
            $items,
            $this->transform,
        );
    }
}
