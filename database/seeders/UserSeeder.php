<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Agency\Agency;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creaet supser admin
        Admin::create([
            'name'=>'Super Admin',
            'email'=>'superadmin@gmail.com',
            'password'=>bcrypt('password'),
        ]);

        //create agency
        Agency::create([
            'name'=>'Demo Agency',
            'network_code' => 'demo'
        ]);

        //create users
        $users = [
            [
                'name'=>'Owner',
                'email'=>'owner@gmail.com',
                'agency_id'=>1,
                'password'=>bcrypt('password'),
                'role'=>'Owner',
            ],
            [
                'name'=>'Advertiser',
                'email'=>'advertiser@gmail.com',
                'agency_id'=>1,
                'password'=>bcrypt('password'),
                'role'=>'Advertiser',
            ],
            [
                'name'=>'Publisher',
                'email'=>'publisher@gmail.com',
                'agency_id'=>1,
                'password'=>bcrypt('password'),
                'role'=>'Publisher',
            ],
        ];

        foreach($users as $user){
            $user = User::create([
                'name'=>$user['name'],
                'email'=>$user['email'],
                'agency_id'=>$user['agency_id'],
                'password'=>$user['password'],
            ]);
            $user->assignRole($user['role']);
        }
    }
}
