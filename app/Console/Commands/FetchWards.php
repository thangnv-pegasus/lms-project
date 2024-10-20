<?php

namespace App\Console\Commands;

use App\Models\District;
use App\Models\Ward;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchWards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-wards';

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
        $districts = District::all();

        foreach ($districts as $key => $district) {
            $districtId = $district->id;
            if ($districtId < 10) {
                $districtId = '00'.$districtId;
            } elseif ($districtId < 100) {
                $districtId = '0'.$districtId;
            }
            $url = getenv('SUPPERSHIP_API_AREA_URL').'/commune?district='.$districtId;
            $response = Http::get($url);
            if ($response->successful()) {
                $data = $response->json();
                $wards = $data['results'];
                foreach ($wards as $key => $wardData) {
                    Ward::updateOrCreate([
                        'id' => $wardData['code'],
                        'name' => $wardData['name'],
                        'district_id' => $district->id,
                    ], [
                        'id' => $wardData['code'],
                        'name' => $wardData['name'],
                        'district_id' => $district->id,
                    ]);
                }
                $this->info('Ward have been successfully fetched and stored.');
            } else {
                $this->error('Failed to fetch ward.');
            }
        }
    }
}
