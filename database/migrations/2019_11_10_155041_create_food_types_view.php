<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodTypesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB:statement("
            create or replace view view_food_types as
            select
            1 as id,
            'Pan seared sea bass piccata with market vegetables, fingerling potatoes, topped with a fresh lemon & caper butter sauce.' as food_type,
            41 as event_id
            union all
            select
            2 as id,
            'Seared Filet of “AAA” Alberta beef brushed with Beurre Marchand de Vin, sautéed baby spinach, foraged wild mushrooms, golden potato pavé, with silky Madeira sauce.' as food_type,
            41 as event_id
            union all
            select
            3 as id,
            'A vegetarian option.' as food_type,
            41 as event_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop view view_food_types');
    }
}
