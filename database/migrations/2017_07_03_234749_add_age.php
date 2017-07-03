<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workers', function (Blueprint $table) {
            //
            $table->integer('age')->unsigned()
            ->after('avatar');
                    });
                    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workers', function (Blueprint $table) {
            //
            $table->dropColumn('age');
        });
    }
}
