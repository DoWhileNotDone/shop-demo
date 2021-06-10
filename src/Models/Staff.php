<?php

namespace Demo\Models;

class Staff
{
    public function __construct(
        private string $first_name,
        private string $last_name,
        private Shop $shop,
    ) {}

    /**
     * Use first name as identifier
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->getFirstName();
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }
}
