<?php

namespace App\Tests\Unit\CarPooling\Domain\Model\Car;

use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    public function testCreateChallenge(): void
    {
        $car = CarFactory::newCar();

        $this->assertSame(1, $car->id());
        $this->assertSame(2, $car->seats());
        $this->assertSame(2, $car->seatsAvailable());
    }


    public function testModifySeatsAvailableChallenge(): void
    {
        $car = CarFactory::newCar();
        $car->setSeatsAvailable(1);

        $this->assertSame(1, $car->id());
        $this->assertSame(2, $car->seats());
        $this->assertSame(1, $car->seatsAvailable());
    }
}