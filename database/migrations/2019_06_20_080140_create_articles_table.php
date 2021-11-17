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
            $table->string('unit')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('volume')->nullable();
            $table->string('stock');
            $table->integer('lead_time');
            $table->string('desc_eng');
            $table->string('desc_fra')->nullable();
            $table->string('desc_spa')->nullable();
            $table->string('details')->nullable();
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
