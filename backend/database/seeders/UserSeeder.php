<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $userAccount = [

            [
                "name" => "admin",
              "email" => "admin@currency.com",
              "password" => "password"
            ]

        ];

        foreach ($userAccount as $item) {

            User::create([
                "name" => "",
                "email" => $item['email'] ,
                "password" => Hash::make($item["password"])
            ]);

        }


    }
}
