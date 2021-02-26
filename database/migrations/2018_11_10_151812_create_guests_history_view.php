<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsHistoryView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            create or replace view view_guests_history as
            select
                g.id,
                g.name,
                g.email,
                g.allergies,
                ftcompanion.food_type as companion_food,
                ftguest.food_type as guest_food,
                g.companion_food as companion_food_id,
                g.guest_food as guest_food_id,
                g.companion_name,
                (
                    case when (g.companion = 2) then
                        'No'
                    when (g.companion = 1) then
                        'Yes'
                    else
                        ''
                    end
                ) as companion,
                g.created_at,
                g.event_id,
                g.token,
                gh2.history_id,
                gh2.history_date,
                gh2.guest_id,
                gh2.status_id,
                gh2.status_name,
                gh2.status_color,
                e.name as event_name
            from guests g
            join view_guests_history_last_status gh2 on gh2.guest_id = g.id
            join events e on e.id = g.event_id
            left join view_food_types ftguest on ftguest.id = g.guest_food
            left join view_food_types ftcompanion on ftcompanion.id = g.companion_food
            where !g.deleted_at
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop view view_guests_history');
    }
}
