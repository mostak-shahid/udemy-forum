<?php

use Illuminate\Database\Seeder;

class ChannelTableSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Channel::class,10)->create();
        App\Channel::create([
        	'title'=>'Welcome',
            'slug'=> 'welcome',
        ]);
    }
}
