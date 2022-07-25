<?php

namespace App\Tests\Unit\CarPooling\Domain\Model\Journey;

use App\CarPooling\Domain\Model\Journey\Journey;

class JourneyFactory
{
    public static function newJourney(): Journey
    {
        return Journey::create(1,2);
    }
}