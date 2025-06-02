<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->enum('sex', ['male', 'female', 'other']);
            $table->string('from_station');
            $table->string('to_station');
            $table->date('journey_date');
            $table->enum('journey_type', ['one-way', 'round-trip']);
            $table->string('class');
            $table->enum('ticket_type', ['regular', 'premium', 'vip']);
            $table->enum('payment_method', ['card', 'cash', 'upi', 'netbanking']);
            $table->string('transaction_id')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
