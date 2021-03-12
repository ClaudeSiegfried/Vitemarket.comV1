<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use \App\Services\StakeholdersManagement;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('name','admin')->first();
        $clientRole = Role::where('name','client')->first();
        $livreurRole = Role::where('name','livreur')->first();
        $fournisseurRole = Role::where('name','fournisseur')->first();

        $admim = User::query()->create([
            'name' => 'admin',
            'email' => 'admin@vitemarket.com',
            'password' => Hash::make('adminadmin'),
            'remember_token' => StakeholdersManagement::ApiToken()
        ]);

        $client = User::query()->create([
            'name' => 'client',
            'email' => 'client@test.com',
            'password' => Hash::make('clienttest'),
            'remember_token' => StakeholdersManagement::ApiToken()

        ]);

        $livreur = User::query()->create([
            'name' => 'livreur',
            'email' => 'livreur@test.com',
            'password' => Hash::make('livreurtest'),
            'remember_token' => StakeholdersManagement::ApiToken()

        ]);

        $fournisseur = User::query()->create([
            'name' => 'fournisseur',
            'email' => 'fournisseur@test.com',
            'password' => Hash::make('fournisseurtest'),
            'remember_token' => StakeholdersManagement::ApiToken()
        ]);

        $admim->roles()->attach($adminRole);
        $client->roles()->attach($clientRole);
        $livreur->roles()->attach($livreurRole);
        $fournisseur->roles()->attach($fournisseurRole);

    }
}
