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
                    'new_price' => $row['new_price'],
                    'old_price' => $row['old_price'],
                    'active_ingredient' => $row['active_ingredient'],
                    'company' => $row['company'],
                    'usage' => $row['usage'],
                    'units' => $row['units'],
                    'dosage_form' => $row['dosage_form'],
                    'parcode' => $row['parcode'],
                ]);
            } else {

                Drug::create([
                    'name_en' => $row['name_en'],
                    'name_ar' => $row['name_ar'],
                    'new_price' => $row['new_price'],
                    'old_price' => $row['old_price'],
                    'active_ingredient' => $row['active_ingredient'],
                    'company' => $row['company'],
                    'usage' => $row['usage'],
                    'units' => $row['units'],
                    'dosage_form' => $row['dosage_form'],
                    'parcode' => $row['parcode'],
                ]);
            }
        }
    }
}
