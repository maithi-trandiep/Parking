<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('place_id')->unsigned()->nullable();
            $table->string('statutR');
            $table->timestamp('dateDemande')->useCurrent();
            $table->timestamp('dateMAJ')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->timestamp('dateDebut')->nullable();
            $table->timestamp('dateFin')->nullable();
        });

        Schema::table('reservation', function (Blueprint $table) {
            $table->foreign('user_id', 'fk_reservation_user')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('place_id', 'fk_reservation_place')
                ->references('id')
                ->on('place')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation');
    }
}
