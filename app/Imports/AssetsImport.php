<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\Importable;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;
use Maatwebsite\Excel\Concerns\SkipsErrors;

use Maatwebsite\Excel\Concerns\WithValidation;


class AssetsImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    use Importable,SkipsErrors;
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
            
                 
            {
               
                if($row['device_type'] == '0' || $row['device_type'] == '1' ){

                
                    if ($row['storage_type'] == '5') {
                        Asset::create([
                                            

                            'name' => $row['name'],
                            'device' => $row['device_type'],
                            'device_sr' => $row['device_sr'],
                            'processor' => $row['processor'],
                            'ram' => $row['ram'],
                            'storage_type' => $row['storage_type'],
                            'ssd' => $row['ssd'],
                            'description' => $row['description'],
                            'status' => 0,

                        ]);
                    }elseif ($row['storage_type'] == '6') {
                        Asset::create([
                            'name' => $row['name'],
                            'device' => $row['device_type'],
                            'device_sr' => $row['device_sr'],
                            'processor' => $row['processor'],
                            'ram' => $row['ram'],
                            'storage_type' => $row['storage_type'],
                            'hdd' => $row['hdd'],
                            
                            'description' => $row['description'],
                            'status' => 0,

                        ]);
                    }else{
                        Asset::create([
                            'name' => $row['name'],
                            'device' => $row['device_type'],
                            'device_sr' => $row['device_sr'],
                            'processor' => $row['processor'],
                            'ram' => $row['ram'],
                            'storage_type' => $row['storage_type'],
                            'ssd' => $row['ssd'],
                            'hdd' => $row['hdd'],
                            'description' => $row['description'],
                            'status' => 0,
                        ]);
                    }
                }elseif ($row['device_type'] == '2' || $row['device_type'] == '3' ) {
                    Asset::create([
                        'name' => $row['name'],
                        'device' => $row['device_type'],
                        'processor' => $row['processor'],
                        'ram' => $row['ram'],
                        'ssd' => $row['storage'],
                        'os' => $row['os'],
                        'imei' => $row['imei'],
                        'description' => $row['description'],
                        'status' => 0,

                    ]);
                    
                }elseif ($row['device_type'] == '4' || $row['device_type'] == '5' || $row['device_type'] == '6') {
                    Asset::create([
                        'name' => $row['name'],
                        'device' => $row['device_type'],
                        'device_sr' => $row['device_sr'],
                        'description' => $row['description'],
                        'status' => 0,
                    ]);
                }
                
            }
            
    }
    
   
}
