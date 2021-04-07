<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseCategoryDestoryRequest;
use App\Http\Requests\ExpenseCategoryStoreRequest;
use App\Http\Requests\ExpenseCategoryUpdateRequest;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Silber\Bouncer\Bouncer;
use Yajra\DataTables\DataTables;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        return view('categories');
    }

    public function table()
    {
        return DataTables::of(ExpenseCategory::all())->setTransformer(function ($value) {
            return [
                'id'            => $value->id,
                'name'          => $value->name,
                'description'   => $value->description,
                'created_by'    => $value->created_by,
                'created_at'    => Carbon::parse($value->created_at)->format('F j, Y'),
                'update_link'   => route('categories.update', ['category' => $value->id]),
                'destroy_link'  => route('categories.destroy', ['category' => $value->id])
            ];
        })->make(true);
    }

    public function store(ExpenseCategoryStoreRequest $request)
    {
        ExpenseCategory::create([
            'name'        => $request->name,
            'description' => $request->description,
            'created_by'  => auth()->id(),
        ]);

        return ['success' => true];
    }

    public function update($category, ExpenseCategoryUpdateRequest $request)
    {
        ExpenseCategory::query()->where('id', $category)->update([
            'name'        => $request->name,
            'description' => $request->description,
            'created_by'  => auth()->id(),
        ]);

        return ['success' => true];
    }

    public function destroy($id, ExpenseCategoryDestoryRequest $request)
    {
        ExpenseCategory::destroy($id);

        return ['success' => true];
    }
}
