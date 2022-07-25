<?php

namespace App\Tests\Unit\CarPooling\Domain\Model\Car;

use App\CarPooling\Domain\Model\Car\Car;

class CarFactory
{
    public static function newCar(): Car
    {
        return Car::create(1,2);
    }
}