<?php

namespace PhpOffice\PhpSpreadsheet;

if (!class_exists(Spreadsheet::class)) {
    class Spreadsheet
    {
        public function getActiveSheet(): Worksheet
        {
            return new Worksheet();
        }
    }
}

if (!class_exists(IOFactory::class)) {
    class IOFactory
    {
        public static function load($filename): Spreadsheet
        {
            return new Spreadsheet();
        }
    }
}

class Worksheet
{
    public function fromArray(array $source, $nullValue = null, string $startCell = 'A1'): void {}
    public function toArray($nullValue = null, bool $calculateFormulas = true, bool $formatData = true, bool $returnCellRef = false): array
    {
        return [];
    }
}

namespace PhpOffice\PhpSpreadsheet\Writer;

if (!class_exists(Xlsx::class)) {
    class Xlsx
    {
        public function __construct($spreadsheet) {}
        public function save($filename) {}
    }
}
