<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Asset::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
            'device',
            'device_sr',
            'device_model',
            'processor',
            'ram',
            'storage_type',
            'ssd',
            'hdd',
            'os',
            'imei',
            'status',
            'description',
            'created_at',
            'updated_at',
        ];
    }
}
