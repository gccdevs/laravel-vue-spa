<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        Role::create([
            'title' => 'Super Admin',
            'slug' => 'super_admin',
            'description' => 'Control everything'
        ]);

        Role::create([
            'title' => 'Admin',
            'slug' => 'admin',
            'description' => 'Manage dashboard'
        ]);

        Role::create([
            'title' => 'Member',
            'slug' => 'member',
            'description' => 'join and view'
        ]);

        User::create([
            'name' => 'TG',
            'email' => 'tonygao@glorycitychurch.com',
            'phone' => '0439031291',
            'api_token' => Uuid::uuid1()->toString() . '_' .Uuid::uuid4()->toString(),
            'user_code' => Uuid::uuid1()->toString() . '_' .Uuid::uuid4()->toString(),
            'password' => bcrypt('JESUSisa1ive'),
            'role_id' => 1,
            'permissions' => json_encode([
                    'manage.user' => 1,
                    'manage.form' => 1,
                    'manage.post' => 1,
                ]),
        ]);
        User::create([
            'name' => 'Guoxiao Lin',
            'email' => 'Guoxiao.lin@glorycitychurch.com',
            'phone' => '000000000',
            'api_token' => Uuid::uuid1()->toString() . '_' .Uuid::uuid4()->toString(),
            'user_code' => Uuid::uuid1()->toString() . '_' .Uuid::uuid4()->toString(),
            'password' => bcrypt('cityonahill1102'),
            'role_id' => 1,
            'permissions' => json_encode([
                    'manage.user' => 1,
                    'manage.form' => 1,
                    'manage.post' => 1,
                ]),
        ]);
        User::create([
            'name' => 'Emma Li',
            'email' => 'emmali@glorycitychurch.com',
            'phone' => '000000000',
            'api_token' => Uuid::uuid1()->toString() . '_' .Uuid::uuid4()->toString(),
            'user_code' => Uuid::uuid1()->toString() . '_' .Uuid::uuid4()->toString(),
            'password' => bcrypt('cityonahill1102'),
            'role_id' => 1,
            'permissions' => json_encode([
                'manage.user' => 1,
                'manage.form' => 1,
                'manage.post' => 1,
            ]),
        ]);
        User::create([
            'name' => 'Encho Aw',
            'email' => 'enchoaw@glorycitychurch.com',
            'phone' => '000000000',
            'api_token' => Uuid::uuid1()->toString() . '_' .Uuid::uuid4()->toString(),
            'user_code' => Uuid::uuid1()->toString() . '_' .Uuid::uuid4()->toString(),
            'password' => bcrypt('cityonahill1102'),
            'role_id' => 1,
            'permissions' => json_encode([
                'manage.user' => 1,
                'manage.form' => 1,
                'manage.post' => 1,
            ]),
        ]);
    }
}
