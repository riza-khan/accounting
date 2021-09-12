<?php

namespace App\Imports;

use App\Http\Controllers\QuickBooksAPIController;
use Maatwebsite\Excel\Concerns\Importable;

class Import  
{
    use Importable;

    public $timestamps = false;
    public $qb;

    public function __construct()
    {
        $this->qb = new QuickBooksAPIController();
    }

    public function batchSize(): int
    {
        return 30;
    }

    public function chunkSize(): int
    {
        return 30;
    }
}
