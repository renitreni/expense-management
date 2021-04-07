<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Faker\Factory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Expense::query()
        ->selectRaw('SUM(Amount) as sum_total, expense_category_id, ec.name')
        ->join('expense_categories as ec', 'ec.id', '=', 'expenses.expense_category_id')
        ->groupBy(['expense_category_id', 'ec.name'])->get()->toArray();

        foreach($data as $key => $value)
        {
            $data[$key]['color'] = Factory::create()->hexColor;
        }

        return view('home', compact('data'));
    }
}
