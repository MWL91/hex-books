<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentBookRequest;
use App\Services\RentBookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RentBookController extends Controller
{
    public function __construct(private readonly RentBookService $rentBookService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(RentBookRequest $request): JsonResponse
    {
        $this->rentBookService->rent($request->user(), $request->getBookId());

        return new JsonResponse([
            'book_id' => $request->getBookId()->toString(),
            'user_id' => $request->user()->getAuthIdentifier(),
        ], 201);
    }
}
