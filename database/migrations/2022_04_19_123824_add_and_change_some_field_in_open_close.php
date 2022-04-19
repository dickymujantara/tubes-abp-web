<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndChangeSomeFieldInOpenClose extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('open_close', function (Blueprint $table) {
            $table->string('close')->after('time');
            $table->renameColumn('time', 'open');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('open_close', function (Blueprint $table) {
            $table->dropColumn('close');
            $table->renameColumn('open', 'time');
        });
    }
}
