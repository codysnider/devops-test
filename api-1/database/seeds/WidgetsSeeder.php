<?php

use Illuminate\Database\Seeder;
use App\Models\Widget;
use App\Models\Widgettype;

class WidgetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($c = 1; $c <= 5; ++$c) {
            Widgettype::create([
                'name' => 'Random Widget Type ' . rand(1,1000),
            ]);
        }


        for ($c = 0; $c <= 100; ++$c) {
            Widget::create([
                'name' => 'Random Widget Name ' . rand(1,1000),
                'size' => rand(1,10),
                'widgettype_id' => rand(1,5),
            ]);
        }
    }
}
