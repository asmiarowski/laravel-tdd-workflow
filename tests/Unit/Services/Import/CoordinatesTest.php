<?php

namespace Tests\Unit\Services\Import;

use App\Exceptions\Import\Coordinates\InvalidFieldsException;
use Tests\TestCase;

class CoordinatesTest extends TestCase
{
    /**
     * Make sure space trimming works properly.
     * Make sure fields in the file can be swapped.
     */
    public function testExtractCsv()
    {
        $filePath = base_path('tests/data/coordinates2.csv');

        $coordinates = new \App\Services\Import\Coordinates();
        $result = $coordinates->extractCSV($filePath);

        $this->assertEquals([
            ['latitude' => 19.0760, 'longitude' => 72.8777],
            ['latitude' => 43.6532, 'longitude' => 79.3832],
            ['latitude' => 22.9068, 'longitude' => 43.1729]
        ], $result);
    }

    /**
     * Make sure class throws proper Exception on invalid fields provided
     */
    public function testInvalidFieldsException()
    {
        $this->expectException(InvalidFieldsException::class);

        $filePath = base_path('tests/data/coordinates3.csv');

        $coordinates = new \App\Services\Import\Coordinates();
        $coordinates->extractCSV($filePath);
    }
}
