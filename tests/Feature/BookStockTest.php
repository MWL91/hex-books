<?php

use App\Models\BookStock;
use App\Models\User;
use function Pest\Laravel\assertDatabaseHas;

describe('Book stock test', function () {

    it('should factor book', function () {
        $bookStock = BookStock::factory()->create();

        assertDatabaseHas('books_stock', [
            'id' => $bookStock->id,
            'name' => $bookStock->name,
            'isbn' => $bookStock->isbn,
            'quantity' => $bookStock->quantity,
            'in_stock' => $bookStock->in_stock,
        ]);
    });

    it('should add book to stock', function () {
        $user = User::factory()->create();

        $request = $this->actingAs($user)->json('POST', '/api/book_stock', [
            'name' => $name = $this->faker->name(),
            'isbn' => $isbn = $this->faker->randomNumber(),
            'quantity' => $quantity = 10,
        ]);

        $id = $request->json('id');

        expect($request->getStatusCode())->toBe(201);
        assertDatabaseHas('books_stock', [
            'id' => $id,
            'name' => $name,
            'isbn' => $isbn,
            'quantity' => $quantity,
            'in_stock' => $quantity,
        ]);
    });
});
