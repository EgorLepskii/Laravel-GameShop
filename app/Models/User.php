<?php

namespace App\Models;

interface User
{
    public function getId(): int;

    public function getName(): string;

    public function getEmail() : string;
}
