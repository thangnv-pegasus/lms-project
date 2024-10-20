<?php

namespace App\Console\Commands;

use App\Models\Province;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchProvinces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-provinces';

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
        $url = getenv('SUPPERSHIP_API_AREA_URL').'/province';
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            $provinces = $data['results'];

            foreach ($provinces as $provinceData) {
                Province::updateOrCreate(
                    ['name' => $provinceData['name'], 'id' => $provinceData['code']],
                    ['name' => $provinceData['name'], 'id' => $provinceData['code']]
                );
            }

            $this->info('Provinces have been successfully fetched and stored.');
        } else {
            $this->error('Failed to fetch provinces.');
        }
    }
}
