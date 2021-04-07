<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseDestroyRequest;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    public function index()
    {

        return view('expense', ['categories' => ExpenseCategory::query()->get()]);
    }

    public function table()
    {
        return DataTables::of(Expense::query()->with('categories'))->setTransformer(function ($value) {
            return [
                'id'            => $value->id,
                'category_name' => $value->categories->name,
                'expense_category_id' => $value->expense_category_id,
                'amount'        => $value->amount,
                'entry_date'    => $value->entry_date,
                'created_by'    => $value->created_by,
                'created_at'    => Carbon::parse($value->created_at)->format('F j, Y'),
                'update_link'   => route('expense.update', ['expense' => $value->id]),
                'destroy_link'  => route('expense.destroy', ['expense' => $value->id])
            ];
        })->make(true);
    }

    public function store(ExpenseStoreRequest $request)
    {
        Expense::create([
            'expense_category_id' => $request->expense_category_id,
            'amount' => $request->amount,
            'entry_date' => $request->entry_date,
            'created_by' => auth()->id()
        ]);

        return ['success' => true];
    }

    public function update(ExpenseUpdateRequest $request)
    {
        Expense::query()->where('id', $request->id)
            ->update([
                'expense_category_id' => $request->expense_category_id,
                'amount' => $request->amount,
                'entry_date' => $request->entry_date
            ]);

        return ['success' => true];
    }

    public function destroy($expense, ExpenseDestroyRequest $request)
    {
        Expense::destroy($expense);

        return ['success' => true];
    }
}
