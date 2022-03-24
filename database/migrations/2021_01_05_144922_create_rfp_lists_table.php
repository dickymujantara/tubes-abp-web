<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfpListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfp_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rfp')->constrained('rfps');
            $table->foreignId('id_account')->constrained('bank_accounts');
            $table->string('code_rfp',15)->unique();
            $table->string('invoice_number');
            $table->string('vendor_name');
            $table->date('date_trasanction');
            $table->date('due_date_trasanction');
            $table->text('description');
            $table->double('amount',12,2);
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
        Schema::dropIfExists('rfp_lists');
    }
}
