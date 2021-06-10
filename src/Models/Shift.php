<?php

namespace Demo\Models;

class Shift
{
    public function __construct(
        private Rota $rota,
        private Staff $staff,
        private \DateTime $start_time,
        private \DateTime $end_time
    ) {
        $this->rota->addShift($this);
    }

    public function getStaff(): Staff
    {
        return $this->staff;
    }

    public function getStartAtTime(): \DateTime
    {
        return $this->start_time;
    }

    public function getEndAtTime(): \DateTime
    {
        return $this->end_time;
    }

    public function getDateWorked(): string
    {
        //TODO: Assuming a shift is in one day
        //TODO: Use constant for format string
        return $this->start_time->format('Y-m-d');
    }

    public function getFirstHourWorked() :int
    {
        return $this->getStartAtTime()->format('G');
    }
    
    public function getLastHourWorked(): int
    {
        return $this->getEndAtTime()->modify("-1 second")->format('G');
    }
}
