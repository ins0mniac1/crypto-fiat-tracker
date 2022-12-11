<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracked_pairs', function (Blueprint $table) {
            $table->id();
            $table->string('driver');
            $table->string('pair');
            $table->float('last_price');
            $table->float('low_price')->nullable();
            $table->float('high_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracked_pairs');
    }
};
