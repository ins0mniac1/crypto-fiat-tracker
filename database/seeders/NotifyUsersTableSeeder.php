<?php

namespace Database\Seeders;

use App\Models\Users\NotifyUser;
use Illuminate\Database\Seeder;

class NotifyUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotifyUser::create(
            [
                'email' => 'test@example.com',
                'pair' => 'BTCUSD',
                'price' => 17000.02,
            ]
        );
    }
}
