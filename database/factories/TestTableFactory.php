<?php

namespace Database\Factories;

use App\Models\TestTable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestTable>
 */
class TestTableFactory extends Factory
{

    protected $model = TestTable::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'Name' => $this->faker->name,
            'Address' => $this->faker->word,
            'Addresss1' => $this->faker->word,
            'Address2' => $this->faker->word,
            'Address3' => $this->faker->word,

        ];
    }
}
