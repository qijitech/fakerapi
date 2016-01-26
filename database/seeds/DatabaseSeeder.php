<?php

use App\Entity\Feed;
use App\Entity\Image;
use App\Entity\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        factory(User::class, 5)->create();
        factory(Feed::class, 100)->create();
        factory(Image::class, 100)->create();
        Model::reguard();
    }
}
