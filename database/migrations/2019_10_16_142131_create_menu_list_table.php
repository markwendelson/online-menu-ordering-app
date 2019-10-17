<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('category')->nullable();
            $table->decimal('price',9,2)->default(0);
            $table->decimal('vat',9,2)->default(0);
            $table->foreign('category')->references('name')->on('menu_category')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_list');
    }
}
