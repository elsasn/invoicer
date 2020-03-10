<?php

use Illuminate\Database\Seeder;

class LocalesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('locales')->delete();
        
        \DB::table('locales')->insert(array (
          0 => 
            array (
                'uuid' => 'c38a0754-7d6a-407b-bc5b-4f10dad0e9b9',
                'locale_name' => 'english',
                'short_name' => 'en',
                'flag' => '1zkkvvsktknz2epc116hexm8cmflqsrcxg6rtecyohml1isx7q.png',
                'default' => '1',
                'status' => 1,
                'created_at' => '2015-09-29 05:19:27',
                'updated_at' => '2017-09-06 07:28:09',
            ),
        ));
        
        
    }
}