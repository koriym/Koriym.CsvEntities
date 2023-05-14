<?php

namespace Koriym\CsvEntities;

final class Memo
{
    public function __construct(
        public string $id,
        public string $title
    ){
    }
}
