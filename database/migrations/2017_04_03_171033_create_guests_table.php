<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuestsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->string('id', 100);
            $table->string('user_id', 100);
            $table->string('guest_group_id', 100);
            $table->string('khmer_full_name', 100)->nullable();
            $table->string('full_name', 100)->nullable();
            $table->string('print_name', 200);
            $table->string('note')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
}
