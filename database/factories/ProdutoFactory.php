<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produto>
 */
class ProdutoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->words(3, true),
            'descricao' => fake()->sentence(),
            'preco' => fake()->randomFloat(2, 10, 1000),
            'quantidade_estoque' => fake()->numberBetween(0, 100),
        ];
    }
}
