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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->integer('stateApply');
            $table->integer('price')->default(0);
            $table->integer('optionPrice');
            $table->integer('quantity')->default(0);;
            $table->integer('optionQuantity');
            $table->dateTime('dateStart')->nullable();
            $table->dateTime('dateEnd')->nullable();
            $table->integer('optionDate');
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
        Schema::dropIfExists('discounts');
    }
};
