<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

interface Product
{
    public function getId(): int;
    public function getCategoryId(): int;
    public function getName(): string;
    public function getImageSrc(): string;
    public function getPrice(): int;
    public function getDescription(): string;


}
