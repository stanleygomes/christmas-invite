<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsHistoryStatusCountView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB:statement('
            create view view_guests_history_status_count as
            select
            count(*) as count,
            status_id,
            status_name
            from view_guests_history vgh
            group by status_id
            order by status_id desc
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop view view_guests_history_status_count');
    }
}
