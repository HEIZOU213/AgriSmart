<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AssetAndStorageFallbackTest extends TestCase
{
    public function test_static_image_fallback_serves_image(): void
    {
        $response = $this->get('/images/nav-logo.png');

        $response->assertStatus(200);
        $this->assertStringContainsString('image/', $response->headers->get('Content-Type'));
    }

    public function test_storage_fallback_serves_file_when_exists(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('testing/sample.jpg', 'fake-image-binary-data');

        $response = $this->get('/storage/testing/sample.jpg');

        $response->assertStatus(200);
    }

    public function test_storage_fallback_returns_404_for_non_existent_file(): void
    {
        $response = $this->get('/storage/does_not_exist_image_xyz.jpg');

        $response->assertStatus(404);
    }

    public function test_storage_fallback_blocks_path_traversal(): void
    {
        $response = $this->get('/storage/../../.env');

        $response->assertStatus(404);
    }

    public function test_link_storage_helper_endpoint(): void
    {
        $response = $this->get('/link-storage');

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'message', 'target']);
    }
}
