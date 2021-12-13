<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = [
            [
                'name' => "Türker Jöntürk",
                'email' => "turker@gmail.com",
                'revenue' => "492.12"
            ],
            [
                'name' => "Kaptan Devopuz",
                'email' => "kaptan@gmail.com",
                'revenue' => "1505.95"
            ], 
            [
                'name' => "İsa Sonuyumaz",
                'email' => "isa@gmail.com",
                'revenue' => "0.00"
            ]
        ];
        
        foreach($customers as $customer){
            $query = Customer::where('email', $customer['email'])->exists();
            if(!$query){
                Customer::create([
                    'email' => $customer['email'],
                    'name' => $customer['name'],
                    'revenue' => $customer['revenue']
                ]);
            }
        }
    }
}
