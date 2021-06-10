<?php

namespace Demo\Models;

class Rota
{
    private array $shifts;

    public function __construct(
        private \DateTime $week_commence_date,
        private Shop $shop,
    ) {
        $this->shifts = [];
    }

    public function addShift(Shift $shift): void
    {
        //TODO: Validate shift is not duplicate
        //TODO: Validate shift is associated with rota
        $this->shifts[] =  $shift;
    }

    public function getShifts(): array
    {
        return $this->shifts;
    }
}
