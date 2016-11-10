<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		factory(App\Product::class, 8)->create()->each(function($p) {
			$p->variations()->save(factory(App\Variation::class)->make());
			$p->variations()->save(factory(App\Variation::class)->make());
			$p->variations()->save(factory(App\Variation::class)->make());
		});
    }
}
