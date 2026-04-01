<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed settings so pages don't error
        $this->artisan('db:seed', ['--class' => 'SettingSeeder']);
    }

    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Selamat Datang');
    }

    public function test_about_page_loads_successfully(): void
    {
        $response = $this->get('/tentang');
        $response->assertStatus(200);
        $response->assertSeeText('Profil');
    }

    public function test_teachers_page_loads_successfully(): void
    {
        $response = $this->get('/guru');
        $response->assertStatus(200);
        $response->assertSeeText('Tenaga Pendidik');
    }

    public function test_gallery_page_loads_successfully(): void
    {
        $response = $this->get('/galeri');
        $response->assertStatus(200);
        $response->assertSeeText('Galeri Kegiatan');
    }

    public function test_posts_page_loads_successfully(): void
    {
        $response = $this->get('/berita');
        $response->assertStatus(200);
    }

    public function test_contact_page_loads_successfully(): void
    {
        $response = $this->get('/kontak');
        $response->assertStatus(200);
    }

    public function test_sitemap_returns_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
    }

    public function test_homepage_has_meta_tags(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $content = $response->getContent();
        
        $this->assertStringContainsString('<meta name="description"', $content);
        $this->assertStringContainsString('<link rel="canonical"', $content);
        $this->assertStringContainsString('og:title', $content);
        $this->assertStringContainsString('application/ld+json', $content);
    }

    public function test_nonexistent_page_returns_404(): void
    {
        $response = $this->get('/halaman-yang-tidak-ada');
        $response->assertStatus(404);
    }
}
