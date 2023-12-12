<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'user'
        ];

        foreach ($roles as $role) {
            $toRole = Role::firstOrCreate(['name' => $role]);

            if( $toRole->name == 'admin' ) {
                $toRole->givePermissionTo(Permission::all());
            }
        }
    }
}
