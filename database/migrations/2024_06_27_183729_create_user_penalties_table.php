<?php

use App\Enums\PenaltyStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_penalties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('amount');
            $table->dateTime('paid_at')->nullable();
            $table->string('status')->default(PenaltyStatus::UNPAID);
            $table->uuid('book_rent_id');
            $table->foreign('book_rent_id')->references('id')->on('book_rents');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_penalties');
    }
};
