<?php

namespace Database\Factories;

use App\Models\Operador;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Operador>
 */
class OperadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Operador::class;

    /**
     * Configure Faker to use Portuguese locale.
     */
    public function withFaker(): Faker
    {
        return \Faker\Factory::create('pt_BR');
    }

    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'cpf' => $this->generateValidCpf(),
            'telefone' => $this->faker->cellphoneNumber(),
            'status' => $this->faker->randomElement([
                Operador::STATUS_LIVRE,
                Operador::STATUS_LIVRE, // Mais chances de estar livre
                Operador::STATUS_LIVRE,
                Operador::STATUS_EM_SERVICO,
            ]),
            'categoria_cnh' => $this->faker->randomElement(['A','B','AB','C','D','E']),
        ];
    }
    
    /**
     * Gera um CPF válido para testes
     */
    private function generateValidCpf(): string
    {
        // Gera os 9 primeiros dígitos
        $cpf = '';
        for ($i = 0; $i < 9; $i++) {
            $cpf .= rand(0, 9);
        }
        
        // Calcula o primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += intval($cpf[$i]) * (10 - $i);
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;
        $cpf .= $digito1;
        
        // Calcula o segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += intval($cpf[$i]) * (11 - $i);
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;
        $cpf .= $digito2;
        
        return $cpf;
    }
}
