<?php

namespace Database\Seeders;

use App\Models\Appeal;
use App\Models\CountryCodes;
use App\Models\Referance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $country_codes = json_decode(file_get_contents(public_path() . "/CountryCodes.json"));
        foreach ($country_codes as $key => $value) {
            CountryCodes::create([
                "name" => $value->name,
                "dial_code" => $value->dial_code,
                "code" => $value->code,
            ]);
        }
        Referance::create(["name" => "Web"]);
        Referance::create(["name" => "Whatsapp"]);
        Referance::create(["name" => "Phone"]);
        $first_name = collect(["Ahmet", "Fikret", "Osman", "Merve", "Semiha"]);
        $last_name = collect(["Altay", "Kurdoğlu", "Yılmaz", "Demir", "Gül"]);
        for ($i = 0; $i < 30; $i++) {
            $countrycodes = CountryCodes::all()->random();
            $date = now()->subDay($i);
            $first_name_last = $first_name->random();
            $last_name_last = $last_name->random();
            Appeal::insert([
                "first_name" => $first_name_last,
                "last_name" => $last_name_last,
                "language_codes" => $countrycodes->id,
                "phone_codes" => $countrycodes->dial_code,
                "phone_number" => rand(),
                "email" => Str::of($first_name_last . "_" . $last_name_last)->lower()  . "@gmail.com",
                "message" => rand(),
                "referances_id" => Referance::all()->random()->id,
                "created_at" => $date,
                "updated_at" => $date,
            ]);
        }
    }
}
