<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropInvoicesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('invoices');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('type')->default(`Invoice`);
            $table->string('invoice_number');
            $table->string('contact');
            $table->longText('description')->nullable();
            $table->string('due_date');
            $table->float('amount');
            $table->text('last_modified');
        });
    }
}
