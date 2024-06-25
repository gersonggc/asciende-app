<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contract;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {

            Contract::withoutEvents(function () {
                // Los observers de Contract no se ejecutarán mientras se estén creando estos contratos.
                Contract::factory(10)->create();
            });

    }
}
