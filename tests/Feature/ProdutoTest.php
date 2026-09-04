<?php

namespace Tests\Feature;

use App\Models\Produto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;

    protected function autenticar(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        return $user;
    }

    public function test_lista_produtos_paginados(): void
    {
        $this->autenticar();

        Produto::factory()->count(15)->create();

        $response = $this->getJson('/api/produtos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page',
                'last_page',
                'total',
            ])
            ->assertJsonCount(10, 'data'); // padrão de 10 por página
    }

    public function test_cria_produto_com_dados_validos(): void
    {
        $this->autenticar();

        $dados = [
            'nome' => 'Teclado Mecânico',
            'descricao' => 'Teclado RGB',
            'preco' => 250.90,
            'quantidade_estoque' => 15,
        ];

        $response = $this->postJson('/api/produtos', $dados);

        $response->assertStatus(201)
            ->assertJsonFragment(['nome' => 'Teclado Mecânico']);

        $this->assertDatabaseHas('produtos', ['nome' => 'Teclado Mecânico']);
    }

    public function test_nao_cria_produto_sem_nome(): void
    {
        $this->autenticar();

        $dados = [
            'preco' => 100,
        ];

        $response = $this->postJson('/api/produtos', $dados);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome']);
    }

    public function test_mostra_um_produto_especifico(): void
    {
        $this->autenticar();

        $produto = Produto::factory()->create();

        $response = $this->getJson("/api/produtos/{$produto->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $produto->id]);
    }

    public function test_retorna_404_para_produto_inexistente(): void
    {
        $this->autenticar();

        $response = $this->getJson('/api/produtos/9999');

        $response->assertStatus(404);
    }

    public function test_atualiza_produto_existente(): void
    {
        $this->autenticar();

        $produto = Produto::factory()->create(['preco' => 100]);

        $response = $this->putJson("/api/produtos/{$produto->id}", [
            'preco' => 199.90,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['preco' => 199.9]);

        $this->assertDatabaseHas('produtos', ['id' => $produto->id, 'preco' => 199.90]);
    }

    public function test_remove_produto(): void
    {
        $this->autenticar();

        $produto = Produto::factory()->create();

        $response = $this->deleteJson("/api/produtos/{$produto->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
    }

    public function test_bloqueia_acesso_sem_autenticacao(): void
    {
        $response = $this->getJson('/api/produtos');

        $response->assertStatus(401);
    }

    public function test_exporta_produtos_em_xml(): void
    {
        $this->autenticar();

        Produto::factory()->count(3)->create();

        $response = $this->get('/api/produtos-xml');

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/xml');

        $xml = simplexml_load_string($response->getContent());
        $this->assertCount(3, $xml->produto);
    }
}
