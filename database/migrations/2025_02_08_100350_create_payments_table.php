<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assuming you have a users table
            $table->decimal('amount', 10, 2);
            $table->string('payment_method'); // e.g., 'Bkash', 'Nagad', 'Rocket'
            $table->string('transaction_id')->unique(); // Unique transaction ID from the payment gateway
            $table->string('status'); // e.g., 'pending', 'completed', 'failed'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}