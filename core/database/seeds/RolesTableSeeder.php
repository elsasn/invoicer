<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'uuid' => '27f41653-a968-4885-8000-7aaf4efc385d',
                'name' => 'staff ',
                'description' => 'staff member with limited privileges',
                'created_at' => '2016-07-25 15:14:06',
                'updated_at' => '2016-08-02 14:38:36',
            ),
            1 => 
            array (
                'uuid' => '5c7f11d2-7091-4d10-aaeb-a9b4e3b76a76',
                'name' => 'admin',
                'description' => 'This is the system admin who has all the administrative privileges. ',
                'created_at' => '2016-07-25 14:57:45',
                'updated_at' => '2016-07-25 15:11:17',
            ),
        ));
        
        
    }
}