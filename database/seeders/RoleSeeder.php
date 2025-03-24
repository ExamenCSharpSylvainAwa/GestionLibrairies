<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $roles = ['Gestionnaire', 'Clients'];
        
        foreach ($roles as $roleName) {
           
            Role::firstOrCreate(
                ['name' => $roleName],
                ['guard_name' => 'web'] 
            );
        }
    
        
        // Vous pouvez également attribuer des permissions aux rôles ici
        // $admin->givePermissionTo('permission1', 'permission2');
    }
}