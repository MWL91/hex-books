<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookStockRequest;
use App\Services\BookStockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CreateBookStockController extends Controller
{
    public function __construct(private BookStockService $bookStockService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateBookStockRequest $request): JsonResponse
    {
        $id = Uuid::uuid4();
        $this->bookStockService->addBookToStock($id, $request->getBook(), $request->getQuantity());

        return new JsonResponse([
            'id' => $id,
        ], 201);
    }
}
