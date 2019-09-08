<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTableArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('articles');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group');
            $table->string('family');
            $table->string('article_code')->unique();
            $table->string('category');
            $table->string('desc_eng');
            $table->string('desc_fra');
            $table->string('desc_spa');
            $table->string('details');
            $table->integer('price');
            $table->timestamp('valid');
            $table->string('varchar');
            $table->integer('volume');
            $table->integer('weight');
            $table->timestamps();
        });
    }
}
