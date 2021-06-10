<?php

namespace Demo\Services\SingleManning;

use Demo\DTO\SingleManning;
use Demo\Models\Rota;

class Calculator
{
    public function __construct(
        private array $transform_steps,
    ) {}

    /**
     * Run the steps on the supplied rota
     * Return the data in the required format
     *
     * @param Rota $rota
     * @return SingleManning
     */
    public function __invoke(Rota $rota): SingleManning
    {
        $data = $rota->getShifts();
        foreach ($this->transform_steps as $step) {
            $data = call_user_func($step, $data);
        }
        return new SingleManning($data);
    }
}
