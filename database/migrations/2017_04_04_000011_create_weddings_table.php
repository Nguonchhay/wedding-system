<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWeddingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weddings', function (Blueprint $table) {
            $table->string('id', 100);
            $table->string('user_id', 100);
			$table->string('title', 255);
            $table->string('groom_name', 60);
			$table->string('bride_name', 60);
			$table->string('groom_image', 255)->nullable();
			$table->string('bride_image', 255)->nullable();
			$table->date('start_date');
			$table->date('end_date');
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
        Schema::dropIfExists('weddings');
    }
}
