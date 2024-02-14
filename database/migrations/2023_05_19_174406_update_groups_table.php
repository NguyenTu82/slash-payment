<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            if (Schema::hasColumn('groups', 'merchant_store_id')) {
                $table->dropColumn('merchant_store_id');
            }
            if (Schema::hasColumn('groups', 'group')) {
                $table->dropColumn('group');
            }
            $table->uuid('merchant_parent_store_id')->nullable()->comment('加盟店Parent ID');
            $table->uuid('merchant_children_store_id')->nullable()->comment('加盟店Children ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('merchant_parent_store_id');
            $table->dropColumn('merchant_children_store_id');
        });
    }
}
