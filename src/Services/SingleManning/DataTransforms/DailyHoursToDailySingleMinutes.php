<?php

namespace Demo\Services\SingleManning\DataTransforms;

class DailyHoursToDailySingleMinutes
{
    /**
     * Return an array of the minutes worked alone by each user in a day
     *
     * @param array $day_summary
     * @param string $date
     *
     * @return array
     */
    public function __invoke(array $day_summary, string $date): array
    {
        $mapper = [
            $date => []
        ];

        foreach ($day_summary as $this_staff_id => $this_hours) {
            foreach ($day_summary as $staff_id => $hours) {
                //Don't discount a staff members own hours for a day
                if ($this_staff_id === $staff_id) {
                    continue;
                }
                //Reduce hours worked alone if that hour is worked
                //with another staff member
                $this_hours = array_diff($this_hours, $hours);
            }
            
            $mapper[$date][$this_staff_id] = count($this_hours) * 60;
        }

        return $mapper;
    }
}
