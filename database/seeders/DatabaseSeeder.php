<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();
        $user=User::factory()->create([
            'name'=>'medilyes',
            'email'=>'khmi@gmail.com'
        ]);
        Listing::factory(6)->create([
            'user_id'=>$user->id
        ]);
        // Listing::create([
        //     'title'=> 'Laravel dev',
        //     'tags'=> 'laravel,js',
        //     'company'=> 'my comp',
        //     'location'=> 'biskra',
        //     'email'=> 'khmi@gmail.com',
        //     'website'=> 'https://www.mycomp.com',
        //     'description'=> 'this is to descripe the gig',
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
