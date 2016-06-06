<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabaseForLeaf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h5_seasons', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('contentId');
            $table->string('name', 64);
            $table->string('slug', 64);
            $table->dateTimeTz('startDate');
            $table->dateTimeTz('endDate');
            $table->boolean('isActive');
            $table->timestamps();

            $table->index('slug');
        });

        Schema::create('h5_csrs', function (Blueprint $table) {
            $table->tinyInteger('id', false, true);
            $table->string('name', 32);
            $table->text('tiers');
            $table->primary('id');
        });

        Schema::create('h5_playlists', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->uuid('contentId');
            $table->string('name', 64);
            $table->string('slug', 128);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->index('slug');
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('slug', 32);
            $table->string('gamertag', 32);

            $table->index('slug');
        });

        Schema::create('h5_rankings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('playlist_id', false, true);
            $table->integer('season_id', false, true);
            $table->integer('account_id', false, true);
            $table->tinyInteger('rank', false, true);
            $table->tinyInteger('lastRank', false, true)->nullable();

            $table->tinyInteger('csr_id', false, true);
            $table->tinyInteger('tier', false, true);
            $table->smallInteger('csr', false, true);
            $table->smallInteger('lastCsr', false, true)->nullable();

            $table->timestamps();

            $table->foreign('csr_id')->references('id')->on('h5_csrs');
            $table->foreign('playlist_id')->references('id')->on('h5_playlists');
            $table->foreign('season_id')->references('id')->on('h5_seasons');
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        Schema::create('h5_season_playlists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_id', false, true);
            $table->integer('playlist_id', false, true);

            $table->foreign('season_id')->references('id')->on('h5_seasons');
            $table->foreign('playlist_id')->references('id')->on('h5_playlists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('h5_season_playlists');
        Schema::dropIfExists('h5_rankings');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('h5_csrs');
        Schema::dropIfExists('h5_playlists');
        Schema::dropIfExists('h5_seasons');
    }
}
