<?php

namespace Pvtl\VoyagerPortfolio\Tests\Unit;

use Tests\TestCase;
use Pvtl\VoyagerPortfolio\Portfolio;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PortfolioTest extends TestCase
{
    use DatabaseMigrations;

    protected function createPortfolio()
    {
        return factory(Portfolio::class)->create([
            'title' => 'Hello World!',
            'slug' => 'hello-world',
            'status' => 'PUBLISHED',
            'featured' => 1,
            'category_id' => 1,
            'image' => 'posts/post1.jpg',
            'excerpt' => 'Lorem ipsum die sip petris...',
            'body' => '<p>There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain. What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><p>What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. There is no one who loves pain itself, who seeks after it and wants to have it.</p>',
            'testimonial' => '<p>There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain. What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><p>What is Lorem Ipsum? Lorem Ipsum is simply dummy text of the printing and typesetting industry. There is no one who loves pain itself, who seeks after it and wants to have it.</p>',
            'testimonial_author' => 'John Smith',
            'meta_title' => 'Hello World! - From Pivotal',
            'meta_description' => 'There is no one who loves pain itself, who seeks after',
        ]);
    }

    public function testStoringAndFetchingData()
    {
        // 1. Arrange
        $portfolio = $this->createPortfolio();

        // 2. Act
        $portfolio->fresh();

        // 3. Assert
        $this->assertObjectHasAttribute('excerpt', $portfolio->data);
        $this->assertEquals($portfolio->data->excerpt, 'Lorem ipsum die sip petris...');
    }
}
