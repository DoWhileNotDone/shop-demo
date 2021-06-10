<?php

namespace Demo\DTO;

final class SingleManning
{
    public function __construct(
        public array $weekly_breakdown,
    ) {}
}
