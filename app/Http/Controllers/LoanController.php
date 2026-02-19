<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreLoanRequest;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LoanController extends Controller
{
    public function store(StoreLoanRequest $request): JsonResponse
    {
        $book = Book::findOrFail($request->book_id);

        if ($book->available_copies <=0) {
            return response()->json(['message' => 'No hay copias disponibles para este libro.', 
            'errors' => [
                'book_id' => ['No hay copias disponibles para este libro.']
            ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $loan = Loan::create([
            'solicitor_name' => $request->solicitor_name,
            'loan_date' => now(),
            'book_id' => $request->book_id,
        ]);

        if ($book->available_copies === 0) {
            $book->is_available = false;
        }

        $book->save();

        return response()->json([
            'message' => 'Préstamo creado exitosamente.',
            'loan' => [
                'id' => $loan->id,
                'solicitor_name' => $loan->solicitor_name,
                'loan_date' => $loan->loan_date,
                'book_id' => $loan->book_id,
                'book_title' => $book->title,
            ]
        ], response::HTTP_CREATED);
    }    
    public function return($loanId): JsonResponse
        {
            $loan = Loan::findOrFail($loanId);
           if ($loan->isReturned()) {
                return response()->json(['message' => 'Este préstamo ya ha sido devuelto.'], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $loan->return_date = now();
            $loan->save();

            $book = $loan->book;

            $book->available_copies += 1;

            if ($book->is_available && $book->available_copies > 0) {
                $book->is_available = true;
            }

            $book->save();


            return response()->json(
                ['message' => 'Libro devuelto exitosamente.',
                'loan'=> [
                    'id' => $loan->id,
                    'solicitor_name' => $loan->solicitor_name,
                    'loan_date' => $loan->loan_date,
                    'return_date' => $loan->return_date,
                    'book_id' => $loan->book_id,
                    'book_title' => $book->title,
                ]
                ], Response::HTTP_OK);
    }

    public function index()
    {
        $loans = Loan::with('book')->get()->map(function ($loan) {
            return [
                'id' => $loan->id,
                'solicitor_name' => $loan->solicitor_name,
                'loan_date' => $loan->loan_date,
                'return_date' => $loan->return_date,
                'is_available' => $loan->isReturned() ? 'Devuelto' : 'Activo',
                'book' => [
                    'id' => $loan->book->id,
                    'title' => $loan->book->title,
                    'ISBN' => $loan->book->ISBN,
                ],
            ];
        });

        return response()->json(
            ['loans' => $loans,
            'total' => $loans->count()], Response::HTTP_OK);
    }
}
