<?php

namespace App\Exports;

use App\Models\Approval;
use Maatwebsite\Excel\Concerns\FromCollection;

class EntriesExport implements FromCollection
{
    public function collection()
    {
        return Approval::select('id', 'title', 'description', 'created_at')->get();
    }
}
