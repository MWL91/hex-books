<?php

use App\Enums\BookRentStatus;
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
        Schema::create('book_rents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('book_id');
            $table->foreign('book_id')->references('id')->on('books_stock');
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->dateTime('rented_at');
            $table->dateTime('returned_at')->nullable();
            $table->string('status')->default(BookRentStatus::RENTED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_rents');
    }
};
