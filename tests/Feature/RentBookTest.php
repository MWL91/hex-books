<?php

use App\Enums\BookRentStatus;
use App\Enums\PenaltyStatus;
use App\Models\BookRent;
use App\Models\BookStock;
use App\Models\User;
use App\Models\UserPenalty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

describe('Rent book', function () {
    it('should allow user to rent a book', function () {
        $user = User::factory()->create();
        $bookInStock = BookStock::factory()->create([
            'quantity' => 10,
            'in_stock' => 10,
        ]);

        $response = $this->actingAs($user)->json('POST', '/api/rent_book', [
            'book_id' => $bookInStock->getKey(),
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'book_id' => $bookInStock->id,
            'user_id' => $user->id,
        ]);
        assertDatabaseHas('book_rents', [
            'book_id' => $bookInStock->getKey(),
            'user_id' => $user->getKey(),
            'rented_at' => now(),
            'returned_at' => null,
            'status' => BookRentStatus::RENTED,
        ]);
        assertDatabaseHas('books_stock', [
            'id' => $bookInStock->getKey(),
            'in_stock' => 9,
        ]);
    });

    it('should allow user to return a book on term', function() {
        $user = User::factory()->create();
        $bookInStock = BookStock::factory()->create([
            'quantity' => 10,
            'in_stock' => 9,
        ]);
        $bookRented = BookRent::factory()->create([
            'book_id' => $bookInStock->getKey(),
            'user_id' => $user->getKey(),
            'rented_at' => now()->subDays(15),
            'status' => BookRentStatus::RENTED,
        ]);

        $response = $this->actingAs($user)->json('POST', '/api/return_book/'.$bookRented->getKey());

        $response->assertStatus(200);
        $response->assertJson([
            'book_id' => $bookRented->getKey(),
            'user_id' => $user->getKey(),
        ]);
        assertDatabaseHas('book_rents', [
            'book_id' => $bookInStock->getKey(),
            'user_id' => $user->getKey(),
            'rented_at' => now()->subDays(15),
            'returned_at' => now(),
            'status' => BookRentStatus::RETURNED,
        ]);
        assertDatabaseHas('books_stock', [
            'id' => $bookInStock->getKey(),
            'in_stock' => 10,
        ]);
        assertDatabaseMissing('user_penalties', [
            'user_id' => $user->getKey(),
            'status' => PenaltyStatus::UNPAID,
            'book_rent_id' => $bookRented->getKey(),
        ]);
    });

    it('should create penalty when user to return book after term', function() {
        $user = User::factory()->create();
        $bookInStock = BookStock::factory()->create([
            'quantity' => 10,
            'in_stock' => 9,
        ]);
        $bookRented = BookRent::factory()->create([
            'book_id' => $bookInStock->getKey(),
            'user_id' => $user->getKey(),
            'rented_at' => now()->subDays(31),
            'status' => BookRentStatus::RENTED,
        ]);

        $response = $this->actingAs($user)->json('POST', '/api/return_book/'.$bookRented->getKey());

        $response->assertStatus(200);
        $response->assertJson([
            'book_id' => $bookRented->getKey(),
            'user_id' => $user->getKey(),
        ]);
        assertDatabaseHas('book_rents', [
            'book_id' => $bookInStock->getKey(),
            'user_id' => $user->getKey(),
            'rented_at' => now()->subDays(31),
            'returned_at' => now(),
            'status' => BookRentStatus::RETURNED,
        ]);
        assertDatabaseHas('books_stock', [
            'id' => $bookInStock->getKey(),
            'in_stock' => 10,
        ]);
        assertDatabaseHas('user_penalties', [
            'user_id' => $user->getKey(),
            'amount' => 1000,
            'status' => PenaltyStatus::UNPAID,
            'book_rent_id' => $bookRented->getKey(),
        ]);
    });
});
