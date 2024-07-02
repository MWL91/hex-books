<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturnBookRequest;
use App\Services\RentBookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReturnBookController extends Controller
{
    public function __construct(private RentBookService $rentBookService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(ReturnBookRequest $request): JsonResponse
    {
        $this->rentBookService->return($request->user(), $request->rentId());

        return new JsonResponse([
            'message' => 'Book returned successfully',
            'book_id' => $request->rentId()->toString(),
            'user_id' => $request->user()->getAuthIdentifier(),
        ]);
    }
}
