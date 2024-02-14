<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postal', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->unique()->comment('郵便番号ID');
            $table->string('code', 25)->nullable()->comment('郵便番号コード');
            $table->text('json')->nullable()->comment('Json');
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postal');
    }
}
