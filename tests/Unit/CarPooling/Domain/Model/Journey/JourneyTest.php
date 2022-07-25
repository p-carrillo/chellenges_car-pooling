<?php

namespace App\Tests\Unit\CarPooling\Domain\Model\Journey;

use App\CarPooling\Domain\Model\Journey\Journey;
use App\Tests\Unit\CarPooling\Domain\Model\Car\CarFactory;
use PHPUnit\Framework\TestCase;

class JourneyTest extends TestCase
{
    public function testCreateJourney(): void
    {
        $journey = JourneyFactory::newJourney();

        $this->assertSame(1, $journey->id());
        $this->assertSame(2, $journey->people());
    }


    public function testassignCarworrks(): void
    {
        $journey = JourneyFactory::newJourney();
        $car = CarFactory::newCar();

        $journey->assignCar($car);

        $this->assertSame(1, $journey->id());
        $this->assertSame(2, $journey->people());
        $this->assertSame(1, $journey->carAssigned()->id());
    }
}