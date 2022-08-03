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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->string('name_bank');
            $table->string('name_credit');
            $table->float('min_summ')->default(0.00);
            $table->float('max_summ')->default(0.00);
            $table->float('initial_payment')->default(0.00);
            $table->integer('percent')->default(0);
            $table->integer('min_term');
            $table->integer('max_term');
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
        Schema::dropIfExists('credits');
    }
};
