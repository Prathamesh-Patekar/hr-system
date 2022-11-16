<?php

namespace App\Exports;

use App\Models\Holiday;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;


class HolidayExport implements FromQuery,WithMapping, WithHeadings
{
    /**
    * @var Invoice $invoice
    */
    use Exportable;

    public function query()
    {
        return Holiday::query();
    }

    public function map($invoice): array
    {
        return [
            $invoice->occasion,
            date('d-m-Y',strtotime($invoice->date_from)),
        ];
    }
    public function headings(): array
    {
        return [
            'occasion',
            'date',
        ];
    }
}
