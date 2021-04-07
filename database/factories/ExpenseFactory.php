<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'expense_category_id' => ExpenseCategory::inRandomOrder()->first()->id,
            'amount' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'entry_date' => Carbon::now(),
            'created_by' => 'seeder'
        ];
    }
}
