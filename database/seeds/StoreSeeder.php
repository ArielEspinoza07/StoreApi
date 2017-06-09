<?php

use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superZapatos  =   App\Models\Store::create(
            array(
                'name'      => 'Super Zapatos',
                'address'   =>  'Alajuela, Alajuela, Alajuela'
            )
        );

        App\Models\Article::create(
            array(
                'name'              =>  'Nike',
                'description'       =>  'NIKE AIR FORCE 1 MID 07',
                'price'             =>  95,
                'total_in_shelf'    =>  50,
                'total_in_vault'    =>  100,
                'store_id'          =>  $superZapatos->id
            )
        );

        App\Models\Article::create(
            array(
                'name'              =>  'Nike',
                'description'       =>  'NIKE SB STEFAN JANOSKI MAX',
                'price'             =>  110,
                'total_in_shelf'    =>  50,
                'total_in_vault'    =>  100,
                'store_id'          =>  $superZapatos->id
            )
        );

        App\Models\Article::create(
            array(
                'name'              =>  'Dr. Martens',
                'description'       =>  '1460 WASHED CANVAS - BLACK WASHED CANVAS',
                'price'             =>  125,
                'total_in_shelf'    =>  100,
                'total_in_vault'    =>  200,
                'store_id'          =>  $superZapatos->id
            )
        );

        App\Models\Article::create(
            array(
                'name'              =>  'Dr. Martens',
                'description'       =>  'BEAVIS & BUTT-HEAD PASCAL - BLACK+WHITE B&B SMOOTH+BACKHAND',
                'price'             =>  150,
                'total_in_shelf'    =>  100,
                'total_in_vault'    =>  200,
                'store_id'          =>  $superZapatos->id
            )
        );

        App\Models\Article::create(
            array(
                'name'              =>  'Dr. Martens',
                'description'       =>  'KAMAR - BLACK HI SUEDE WP PERFED',
                'price'             =>  130,
                'total_in_shelf'    =>  100,
                'total_in_vault'    =>  200,
                'store_id'          =>  $superZapatos->id
            )
        );

        App\Models\Article::create(
            array(
                'name'              =>  'Dr. Martens',
                'description'       =>  '1460 SMOOTH - BLACK SMOOTH',
                'price'             =>  135,
                'total_in_shelf'    =>  100,
                'total_in_vault'    =>  200,
                'store_id'          =>  $superZapatos->id
            )
        );
    }
}
