<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceGroup;
use App\Models\ServiceSupportCategory;
use Box\Spout\Common\Exception\IOException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class CreateServices extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $basePath = Storage::path('data');
            $collection = (new FastExcel())->import("{$basePath}/NDIS_Support_Catalogue_2022-23_v1.0.xlsx");
        }catch (IOException $e){
            $collection = [];
        }
        foreach ($collection as $item){
            Service::updateOrCreate(
                ['support_item_number' => $item["Support Item Number"]],
                [
                    'support_item_name' => $item["Support Item Name"],
                    'reg_group_number' => $item["Registration Group Number"],
                    'reg_group_name' =>  $item["Registration Group Name"],
                    'support_category_number' => $item["Support Category Number"],
                    'support_category_name' => $item["Support Category Name"],
                    //STATES:
                    'ACT' => ifEmptyReturnNull($item['ACT']),
                    'NSW' => ifEmptyReturnNull($item['NSW']),
                    'NT' => ifEmptyReturnNull($item['NT']),
                    'QLD' => ifEmptyReturnNull($item['QLD']),
                    'SA' => ifEmptyReturnNull($item['SA']),
                    'TAS' => ifEmptyReturnNull($item['TAS']),
                    'VIC' => ifEmptyReturnNull($item['VIC']),
                    'WA' => ifEmptyReturnNull($item['WA']),
                    'unit' => ifEmptyReturnNull($item['Unit']),
                    'quote' => ifEmptyReturnNull($item['Quote']),
                    'remote' => ifEmptyReturnNull($item['P01']),
                    'very_remote' => ifEmptyReturnNull($item['P02']),

                    'non_face_to_face' => ifEmptyReturnNull($item['Non-Face-to-Face Support Provision']),
                    'provider_travel' => ifEmptyReturnNull($item['Provider Travel']),
                    'short_notic_cancellations' => ifEmptyReturnNull($item['Short Notice Cancellations.']),
                    'ndia_requested_reports' => ifEmptyReturnNull($item['NDIA Requested Reports']),
                    'irregular_sil_supports' => ifEmptyReturnNull($item['Irregular SIL Supports']),
                    'type' => ifEmptyReturnNull($item['Type'])
                ]
            );
        }

    }
}
