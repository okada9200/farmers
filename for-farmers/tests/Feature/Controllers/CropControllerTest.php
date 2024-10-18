<?php

namespace Tests\Feature\Controllers;

use App\Models\Crop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CropControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexDisplaysCrops()
    {
        $crop = Crop::factory()->create();

        $response = $this->get(route('crops.index'));

        $response->assertStatus(200);
        $response->assertViewIs('crops.index');
        $response->assertSee($crop->name);
    }

    // public function testStoreCreatesNewCrop()
    // {
    //     $data = [
    //         'name' => 'Test Crop',
    //         'type' => 'Vegetable',
    //         'variety' => 'Carrot',
    //         'planting_date' => '2023-10-10',
    //         'address' => 'Test Address',
    //     ];

    //     $response = $this->post(route('crops.store'), $data);

    //     $response->assertRedirect(route('crops.index'));
    //     $this->assertDatabaseHas('crops', ['name' => 'Test Crop']);
    // }

    // public function testDestroyCrops()
    // {
    //     $crop = Crop::factory()->create();

    //     $response = $this->delete(route('crops.destroy', $crop->id));

    //     $response->assertRedirect(route('crops.index'));

    //     // 物理削除を確認
    //     $this->assertDatabaseMissing('crops', ['id' => $crop->id]);

    //     // ソフトデリートを使用している場合は以下を使用
    //     // $this->assertSoftDeleted('crops', ['id' => $crop->id]);
    // }

    // public function testEnvironmentIsTesting()
    // {
    //     // 環境変数を確認
    //     $this->assertEquals('testing', env('APP_ENV'));
    //     $this->assertEquals('testing', app()->environment());

    //     // データベース接続が 'sqlite' であることを確認
    //     $this->assertEquals('sqlite', config('database.default'));

    //     // データベース名が ':memory:' であることを確認
    //     $this->assertEquals(':memory:', config('database.connections.sqlite.database'));
    // }
}
