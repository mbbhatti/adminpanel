<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'key' => 'site.title',
                'display_name' => 'Site Title',
                'value' => 'Site Title',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Site'
            ], [
                'key' => 'site.description',
                'display_name' => 'Site Description',
                'value' => 'Site Description',
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Site'
            ], [
                'key' => 'site.logo',
                'display_name' => 'Site Logo',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Site'
            ], [
                'key' => 'admin.bg_image',
                'display_name' => 'Admin Background Image',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 5,
                'group' => 'Admin'
            ], [
                'key' => 'admin.title',
                'display_name' => 'Admin Title',
                'value' => 'Admin Title',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Admin'
            ], [
                'key' => 'admin.description',
                'display_name' => 'Admin Description',
                'value' => 'Welcome to food admin panel',
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Admin'
            ], [
                'key' => 'admin.loader',
                'display_name' => 'Admin Loader',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Admin'
            ], [
                'key' => 'admin.icon_image',
                'display_name' => 'Admin Icon Image',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 4,
                'group' => 'Admin'
            ], [
                'key' => 'mail.server',
                'display_name' => 'Mail Server',
                'value' => 'smtp.mailtrap.io',
                'details' => '',
                'type' => 'text',
                'order' => 0,
                'group' => 'mail'
            ] , [
                'key' => 'mail.port',
                'display_name' => 'Mail Port',
                'value' => '2525',
                'details' => '',
                'type' => 'text',
                'order' => 0,
                'group' => 'mail'
            ], [
                'key' => 'mail.login',
                'display_name' => 'Mail Login',
                'value' => '965428ed000225',
                'details' => '',
                'type' => 'text',
                'order' => 0,
                'group' => 'mail'
            ], [
                'key' => 'mail.password',
                'display_name' => 'Mail Password',
                'value' => '703082e1973f6a',
                'details' => '',
                'type' => 'text',
                'order' => 0,
                'group' => 'mail'
            ]
        ];

        DB::table('settings')->insert($data);
    }
}

