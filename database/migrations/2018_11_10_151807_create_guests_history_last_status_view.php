<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsHistoryLastStatusView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            create view view_guests_history_last_status as
            select
                gh.id as history_id,
                g.allergies,
                g.guest_food,
                g.companion_food,
                g.companion_name,
                gh.guest_id,
                gh.status_id,
                gh.created_at as history_date,
                ghs.name as status_name,
                ghs.color as status_color
            from guests_history gh
            join guests g on g.id = gh.guest_id
            join guests_history_status ghs on ghs.id = gh.status_id
            where
                gh.id = (
                    select
                        max(id) as last_history
                    from guests_history gh1
                    where gh1.guest_id = gh.guest_id
                )
                and !gh.deleted_at
                and !ghs.deleted_at
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop view view_guests_history_last_status');
    }
}
