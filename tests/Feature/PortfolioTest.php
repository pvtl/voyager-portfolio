<?php

namespace Pvtl\VoyagerPortfolio\Tests\Feature;

use Tests\TestCase;
use Pvtl\VoyagerPortfolio\Portfolio;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PortfolioTest extends TestCase
{
    use DatabaseMigrations;

    protected function createPortfolio($content = '<p>Hello world!</p>', $status = 'PUBLISHED')
    {
        return factory(Portfolio::class)->create([
            'title' => 'Hello World!',
            'slug' => 'hello-world',
            'status' => $status,
            'featured' => 1,
            'category_id' => 1,
            'image' => 'posts/post1.jpg',
            'excerpt' => 'Lorem ipsum die sip petris...',
            'body' => $content,
            'testimonial' => $content,
            'testimonial_author' => 'John Smith',
            'seo_title' => 'Hello World! - From Pivotal',
            'meta_description' => 'There is no one who loves pain itself, who seeks after',
        ]);
    }

    public function testIfPortfolioIsVisible()
    {
        // Create new "portfolio" item
        $portfolioItem = $this->createPortfolio();

        // 2. Act
        $response = $this->get('/portfolio/hello-world');

        // 3. Assert
        $response
            ->assertStatus(200)
            ->assertSee('<p>Hello world!</p>');
    }

    public function testIfPortfolioIsHidden()
    {
        // Create new "/home" page and associate a page block
        $portfolioItem = $this->createPortfolio('', 'DRAFT');

        // 2. Act
        $response = $this->get('/portfolio/hello-world');

        // 3. Assert
        $response
            ->assertStatus(200)
            ->assertDontSee('<p>Hello world!</p>');
    }
}
