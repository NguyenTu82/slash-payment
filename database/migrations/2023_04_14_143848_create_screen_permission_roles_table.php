<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreenPermissionRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screen_permission_roles', function (Blueprint $table) {
            $table->unsignedInteger('screen_id')->comment('画面ID');
            $table->unsignedInteger('permission_id')->comment('権限ID');
            $table->uuid('role_id')->comment('役割ID');
            $table->tinyInteger('active')->default(0)->comment('有効・無効');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('screen_permission_roles');
    }
}
