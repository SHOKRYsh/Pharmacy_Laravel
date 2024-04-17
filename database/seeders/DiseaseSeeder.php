<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table("diseases")->insert([

            ["name_en" => "Diabetes", "name_ar" => "السكري"],
            ["name_en" => "Hypertension ", "name_ar" => "ارتفاع ضغط الدم"],
            ["name_en" => "Coronary artery disease", "name_ar" => "أمراض الشرايين التاجية"],
            ["name_en" => "Chronic obstructive pulmonary disease", "name_ar" => "الأمراض المزمنة التنفسية التحسسية"],
            ["name_en" => "Asthma ", "name_ar" => "الربو"],
            ["name_en" => "Chronic kidney disease", "name_ar" => "الأمراض المزمنة للكلى"],
            ["name_en" => "Chronic liver disease", "name_ar" => "أمراض الكبد المزمنة"],
            ["name_en" => "Rheumatoid arthritis", "name_ar" => "التهاب المفاصل الروماتويدي"],
            ["name_en" => "Osteoarthritis", "name_ar" => "التهاب المفاصل التنكسي"],
            ["name_en" => "Chronic heart failure", "name_ar" => "قصور القلب المزمن"],
            ["name_en" => "Chronic back pain", "name_ar" => "ألم الظهر المزمن"],
            ["name_en" => "Alzheimer's disease", "name_ar" => "مرض الزهايمر"],
            ["name_en" => "Parkinson's disease", "name_ar" => "مرض باركنسون"],
            ["name_en" => "Multiple sclerosis", "name_ar" => "التصلب المتعدد"],
            ["name_en" => "Cancer", "name_ar" => "السرطان"],
            ["name_en" => "Chronic obstructive pulmonary disease", "name_ar" => "الأمراض المزمنة التنفسية التحسسية"],
            ["name_en" => "Inflammatory bowel disease", "name_ar" => "الأمراض التهابية للأمعاء"],
            ["name_en" => "Cystic fibrosis", "name_ar" => "التليف الكيسي"],
            ["name_en" => "End-stage renal disease", "name_ar" => "الفشل الكلوي المتقدم"],
            ["name_en" => "Systemic lupus erythematosus", "name_ar" => "ذئبية الجلد المنتشرة"],
            ["name_en" => "Crohn's disease", "name_ar" => "مرض كرون"],
            ["name_en" => "Ankylosing spondylitis", "name_ar" => "التهاب المفاصل العنقودي التصلبي"],
            ["name_en" => "Chronic migraine", "name_ar" => "الصداع النصفي المزمن"],
            ["name_en" => "Chronic pancreatitis", "name_ar" => "التهاب البنكرياس المزمن"],
            ["name_en" => "Chronic obstructive uropathy", "name_ar" => "انسداد الجهاز البولي المزمن"],
            ["name_en" => "Chronic fatigue syndrome", "name_ar" => "متلازمة الإرهاق المزمن"],
            ["name_en" => "Chronic inflammatory demyelinating polyneuropathy", "name_ar" => "التهاب الأعصاب الساد المزمن"],
            ["name_en" => "Sickle cell disease", "name_ar" => "مرض الانحناء الخلقي"],
            ["name_en" => "Chronic venous insufficiency", "name_ar" => "عدم كفاية الأوردة المزمنة"],
            ["name_en" => "Huntington's disease", "name_ar" => "مرض هنتنجتون"],

        ]);
    }
}
