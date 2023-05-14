<?php

declare(strict_types=1);

namespace Koriym\CsvEntities;

use PHPUnit\Framework\TestCase;

class CsvEntitiesTest extends TestCase
{
    protected CsvEntities $csvEntities;

    protected function setUp(): void
    {
        $this->csvEntities = new CsvEntities();
    }

    public function testIsInstanceOfCsvEntities(): void
    {
        $actual = $this->csvEntities;
        $this->assertInstanceOf(CsvEntities::class, $actual);
    }
}
