<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('article_code')->unique();
            $table->string('category');
            $table->string('group');
            $table->string('family');
            $table->integer('price');
            $table->string('valid');
            $table->string('unit')->null();
            $table->integer('weight')->null();
            $table->integer('volume')->null();
            $table->string('stock');
            $table->integer('lead_time');
            $table->string('desc_eng');
            $table->string('desc_fra')->null();
            $table->string('desc_spa')->null();
            $table->string('details')->null();
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
        Schema::dropIfExists('articles');
    }
}
