<?php

namespace Koriym\CsvEntities;

final class FakeMemo
{
    public function __construct(
        public string $id,
        public string $title
    ){
    }
}
