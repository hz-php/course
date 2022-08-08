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
        Schema::create('homes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false); //Название
            $table->string('street'); //Улица
            $table->string('district'); //Район
            $table->string('city'); //Город
            $table->integer('floor'); //Этаж
            $table->integer('how_many_rooms'); //Сколько комнат
            $table->float('total_area'); //Общая площадь
            $table->float('ceiling_height'); //Высота потолков
            $table->float('plot_area'); //Площадь участка
            $table->integer('how_many_flors'); //Сколько этажей(уровней)
            $table->integer('how_many_flors_house'); //Сколько этажей в доме
            $table->date('year_of_construction'); //Год постройки
            $table->string('type'); //Тип (квартира, дом, участок, комната)
            $table->string('type_ob_transaction'); //Тип сделки
            $table->string('type_of_house'); //Тип дома(кирпич, дерево, монолит)
            $table->string('condition'); //Состояние
            $table->text('description'); //Описание
            $table->text('images'); //Фото
            $table->float('currency'); //Цена
            $table->integer('seller_id')->unsigned()->nullable(true); //Id продавца
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homes');
    }
};
