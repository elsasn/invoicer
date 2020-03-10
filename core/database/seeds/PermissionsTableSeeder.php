<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'uuid' => '10eceb0f-1139-4e4d-ba0c-f7a5dbd428d1',
                'name' => 'add_estimate',
                'description' => 'Allow user to add estimates',
                'created_at' => '2016-08-08 14:18:48',
                'updated_at' => '2016-09-12 11:26:07',
            ),
            1 => 
            array (
                'uuid' => '17164617-61e4-4e4c-beac-bc7cfb7cf1cb',
                'name' => 'add_product',
                'description' => 'Allow user to add products',
                'created_at' => '2016-08-08 14:22:20',
                'updated_at' => '2016-09-12 11:21:59',
            ),
            2 => 
            array (
                'uuid' => '1cd20ed3-3606-49d9-8dad-848a94aeeb72',
                'name' => 'delete_user',
                'description' => 'Allow user to delete user',
                'created_at' => '2016-08-08 14:53:59',
                'updated_at' => '2016-08-23 13:24:03',
            ),
            3 => 
            array (
                'uuid' => '2037231a-ef3a-40dc-921c-3aea2d4172c6',
                'name' => 'add_expense',
                'description' => 'Allow user to add expenses',
                'created_at' => '2016-08-08 14:19:52',
                'updated_at' => '2016-09-12 11:23:48',
            ),
            4 => 
            array (
                'uuid' => '3e5a71a6-b4ea-489b-b330-bed0da6a9322',
                'name' => 'send_estimate',
                'description' => 'Allow user send estimates',
                'created_at' => '2016-10-05 11:53:43',
                'updated_at' => '2016-10-05 11:53:43',
            ),
            5 => 
            array (
                'uuid' => '42693e14-ba6e-465f-9de8-3ff74da853a8',
                'name' => 'delete_invoice',
                'description' => 'Allow users to delete invoices',
                'created_at' => '2016-08-08 13:34:01',
                'updated_at' => '2016-09-12 11:29:56',
            ),
            6 => 
            array (
                'uuid' => '4d8e4c00-f889-4abf-9748-9bbc4d8f9caa',
                'name' => 'delete_estimate',
                'description' => 'Allow user to delete estimates
',
                'created_at' => '2016-08-08 14:19:12',
                'updated_at' => '2016-09-12 11:25:07',
            ),
            7 => 
            array (
                'uuid' => '547492d8-70ae-4c17-a1df-866e9470f6c1',
                'name' => 'edit_estimate',
                'description' => 'Allow user to edit estimates',
                'created_at' => '2016-08-08 14:19:03',
                'updated_at' => '2016-09-12 11:25:43',
            ),
            8 => 
            array (
                'uuid' => '5abcf69a-4efd-46d0-bcef-0f040e407bc4',
                'name' => 'delete_client',
                'description' => 'Allow user access to delete a client',
                'created_at' => '2016-08-08 15:43:37',
                'updated_at' => '2016-08-09 10:32:58',
            ),
            9 => 
            array (
                'uuid' => '63b1e5b9-974c-4870-8215-011fc320bef1',
                'name' => 'delete_expense',
                'description' => 'Allow user to delete expense',
                'created_at' => '2016-08-08 14:20:13',
                'updated_at' => '2016-09-12 11:23:12',
            ),
            10 => 
            array (
                'uuid' => '646b3394-92c9-4972-8430-fe4c6dabcc6a',
                'name' => 'edit_user',
                'description' => 'Allow user to edit system users',
                'created_at' => '2016-08-08 14:53:52',
                'updated_at' => '2016-09-12 11:20:23',
            ),
            11 => 
            array (
                'uuid' => '6c23de41-01df-4e42-a787-6fc364c7ba57',
                'name' => 'add_user',
                'description' => 'Allow user to add other users',
                'created_at' => '2016-08-08 14:53:45',
                'updated_at' => '2016-09-12 11:20:39',
            ),
            12 => 
            array (
                'uuid' => '77e7613a-be8b-4ef9-9fa3-915eea1fa4a2',
                'name' => 'edit_setting',
                'description' => 'Allow user to edit system settings',
                'created_at' => '2016-08-08 14:19:38',
                'updated_at' => '2016-09-12 11:24:12',
            ),
            13 => 
            array (
                'uuid' => '7c2ac4c7-2b18-48e9-b33b-ff19734fa041',
                'name' => 'edit_expense',
                'description' => 'Allow user to edit payment',
                'created_at' => '2016-08-08 14:20:02',
                'updated_at' => '2016-09-12 11:23:29',
            ),
            14 => 
            array (
                'uuid' => '829f7418-9b4f-4a65-842a-82fc2dd98168',
                'name' => 'send_invoice',
                'description' => 'Allow user to send invoices',
                'created_at' => '2016-08-08 13:36:41',
                'updated_at' => '2016-09-12 11:29:40',
            ),
            15 => 
            array (
                'uuid' => '851edead-32bf-4c90-8f7c-911c619c507c',
                'name' => 'view_invoice',
                'description' => 'Allow user to view invoices',
                'created_at' => '2016-08-08 13:05:46',
                'updated_at' => '2016-09-12 11:31:36',
            ),
            16 => 
            array (
                'uuid' => '939325ff-7469-4360-84e5-fe585e7f1dbb',
                'name' => 'add_payment',
                'description' => 'Allow user to add payment',
                'created_at' => '2016-08-08 14:21:49',
                'updated_at' => '2016-09-12 11:22:55',
            ),
            17 => 
            array (
                'uuid' => '9d71bed3-e914-40b8-a579-c603095a239b',
                'name' => 'add_invoice',
                'description' => 'Allow users to add invoices',
                'created_at' => '2016-08-08 13:06:21',
                'updated_at' => '2016-09-12 11:30:13',
            ),
            18 => 
            array (
                'uuid' => 'c4ec0b11-3ecf-434c-8366-43423695fa81',
                'name' => 'delete_product',
                'description' => 'Allow user to delete products',
                'created_at' => '2016-08-08 14:22:33',
                'updated_at' => '2016-09-12 11:21:38',
            ),
            19 => 
            array (
                'uuid' => 'c9dc7c2b-7753-4dce-af40-4adf8aace186',
                'name' => 'add_client',
                'description' => 'Allow user to add clients',
                'created_at' => '2016-08-08 15:43:19',
                'updated_at' => '2016-09-12 11:20:07',
            ),
            20 => 
            array (
                'uuid' => 'cc21e591-f09e-4225-9725-06d2abb84860',
                'name' => 'edit_product',
                'description' => 'Allow user to edit products',
                'created_at' => '2016-08-08 14:22:41',
                'updated_at' => '2016-09-12 11:21:22',
            ),
            21 => 
            array (
                'uuid' => 'cc9fa2fa-1427-4cbb-9b9f-2cb9d5078add',
                'name' => 'view_estimate',
                'description' => 'Allow user to view estimates',
                'created_at' => '2016-08-08 14:19:20',
                'updated_at' => '2016-09-12 11:24:28',
            ),
            22 => 
            array (
                'uuid' => 'd118ad4b-17c4-4798-be1a-4d113860e299',
                'name' => 'edit_client',
                'description' => 'Allow user to edit clients',
                'created_at' => '2016-08-08 15:43:27',
                'updated_at' => '2016-09-12 11:19:51',
            ),
            23 => 
            array (
                'uuid' => 'db8066d7-f495-4886-9a99-1f28144232ed',
                'name' => 'edit_payment',
                'description' => 'Allow user to edit payments',
                'created_at' => '2016-08-08 14:22:11',
                'updated_at' => '2016-09-12 11:22:18',
            ),
            24 => 
            array (
                'uuid' => 'eb556f1c-6a2c-42d6-b020-f5e7b6434c7e',
                'name' => 'delete_payment',
                'description' => 'Allow user to delete payment',
                'created_at' => '2016-08-08 14:21:58',
                'updated_at' => '2016-09-12 11:22:38',
            ),
            25 => 
            array (
                'uuid' => 'f0286cc0-0178-49d9-a3c5-f2783171725d',
                'name' => 'edit_invoice',
                'description' => 'Allow user to edit invoices',
                'created_at' => '2016-08-08 13:06:09',
                'updated_at' => '2016-09-12 11:30:29',
            ),
        ));
        
        
    }
}