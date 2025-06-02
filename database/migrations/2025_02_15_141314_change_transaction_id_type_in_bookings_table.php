<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTransactionIdTypeInBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('transaction_id')->change(); // Change to string
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('transaction_id')->change(); // Change back to integer if needed
        });
    }
}