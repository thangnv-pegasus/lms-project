<?php

namespace App\Console\Commands;

use App\Models\District;
use App\Models\Province;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchDistricts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-districts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $provinces = Province::all();

        foreach ($provinces as $key => $province) {
            $provinceId = $province->id;
            if ($province->id < 10) {
                $provinceId = '0' . $province->id;
            }
            $url = getenv('SUPPERSHIP_API_AREA_URL') . '/district?province=' . $provinceId;

            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();

                $districts = $data['results'];

                foreach ($districts as $districtData) {
                    District::updateOrCreate(
                        ['name' => $districtData['name'], 'id' => $districtData['code'], 'province_id' => $province->id],
                        ['name' => $districtData['name'], 'id' => $districtData['code'], 'province_id' => $province->id]
                    );
                }

                $this->info('District have been successfully fetched and stored.');
            } else {
                $this->error('Failed to fetch districts.');
            }
        }

    }
}
