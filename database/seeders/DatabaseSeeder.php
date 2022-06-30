<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(NavigationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(AccessSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(MacPackageSeeder::class);

        $this->call(ClientTypeSeeder::class);
        $this->call(ProtocolSeeder::class);
        $this->call(BillingStatusSeeder::class);
        $this->call(PaymentmethodSeeder::class);

        $this->call(ItemSeeder::class);
        $this->call(MPoolSeeder::class);
        // $this->call(MSecreatSeeder::class);
        $this->call(MPPPProfileSeeder::class);
        $this->call(MInterfaceSeeder::class);
        $this->call(CustomerSeeder::class);
        // Http::get(route('update_access'));
    }
}
