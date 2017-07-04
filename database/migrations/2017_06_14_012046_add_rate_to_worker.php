<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRateToWorker extends Migration
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
<<<<<<< HEAD
            $table->integer('rate')->unsigned()->after('wage')->default(0);
=======
            $table->float('rate')->after('wage')->default(0);
>>>>>>> master
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
            
            $table->dropColumn('rate');
        });
    }
}
