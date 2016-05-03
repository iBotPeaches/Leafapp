<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsRankedFlagToPlaylist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h5_playlists', function (Blueprint $table)
        {
            $table->boolean('isRanked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('h5_playlists', function (Blueprint $table)
        {
            $table->dropColumn('isRanked');
        });
    }
}
