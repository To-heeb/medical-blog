<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsletterSubscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsletterSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsletterSubscription::factory()
            ->count(3)
            ->create();
    }
}
