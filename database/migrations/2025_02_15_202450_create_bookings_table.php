<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('contactNo')->nullable(); // Define contactNo as nullable
            $table->decimal('amount', 10, 2);
            $table->string('status');
            $table->integer('age');
            $table->string('sex');
            $table->date('date');
            $table->string('journeyType');
            $table->string('class');
            $table->string('ticketType');
            $table->integer('numberOfTickets');
            $table->string('transaction_id')->unique();
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
        Schema::dropIfExists('bookings');
    }
}