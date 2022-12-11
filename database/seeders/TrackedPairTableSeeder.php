<?php

namespace Database\Seeders;

use App\Models\Drivers\TrackedPair;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackedPairTableSeeder extends Seeder
{

    const Driver = 'App\Drivers\Bitfinex\Bitfinex';
    const FOR_MONTHS = 3;
    const FOR_DAYS = 15;
    const FOR_HOURS = 3;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($month = self::FOR_MONTHS; $month >= 1; $month--) {
            for ($day = self::FOR_DAYS; $day >= 0; $day--) {
                for ($hour = self::FOR_HOURS; $hour >= 1; $hour--) {
                    $createdAt = now()->subMonths($month)->subDays($day)->subHours($hour);

                    TrackedPair::create(
                        [
                            'driver' => self::Driver,
                            'pair' => 'BTCUSD',
                            'last_price' => rand(15000.00, 20000.99),
                            'created_at' => $createdAt,
                            'updated_at' => $createdAt,
                        ]
                    );
                }
            }
        }
    }
}
