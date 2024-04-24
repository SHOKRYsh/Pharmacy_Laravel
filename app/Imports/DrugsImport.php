<?php

namespace App\Imports;

use App\Models\Drug;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class DrugsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        //

        foreach ($rows as $row) {
            $drug = Drug::where('name_en', $row['name_en'])->first();
            if ($drug) {
                $drug->update([
                    'name_en' => $row['name_en'],
                    'name_ar' => $row['name_ar'],
                    'image_url' => $row['image_url'],
                    'price' => $row['price'],
                ]);
            } else {

                Drug::create([
                    'name_en' => $row['name_en'],
                    'name_ar' => $row['name_ar'],
                    'image_url' => $row['image_url'],
                    'price' => $row['price'],
                ]);
            }
        }
    }
}
