<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SetupMeiliSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meili:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set MeiliSearch typo tolerance settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = config('scout.meilisearch.host');
        $key = config('scout.meilisearch.key');

        $indexes = ['songs', 'playlists', 'albums', 'artists'];

        foreach ($indexes as $index) {
            $url = $host . "/indexes/{$index}/settings/typo-tolerance";

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $key,
            ])->patch($url, [
                "enabled" => true,
                "minWordSizeForTypos" => [
                    "oneTypo" => 2,
                    "twoTypos" => 5
                ]
            ]);

            if ($response->successful()) {
                $this->info("MeiliSearch typo tolerance set successfully for {$index}!");
            } else {
                $this->error("Failed to set typo tolerance for {$index}: " . $response->body());
            }
        }
    }
}
