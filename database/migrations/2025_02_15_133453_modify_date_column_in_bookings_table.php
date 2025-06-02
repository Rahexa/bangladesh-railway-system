<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDateColumnInBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('date')->default(now())->change(); // Set default value to current date
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('date')->nullable()->change(); // Revert to nullable if needed
        });
    }
}