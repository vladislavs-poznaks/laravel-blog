<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlesControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_an_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->followingRedirects();

        $this->post(route('articles.store'), [
            'title' => 'Test Title',
            'content' => 'Test Content'
        ])
            ->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'user_id' => $user->id,
            'title' => 'Test Title',
            'content' => 'Test Content'
        ]);
    }

    /** @test */
    public function user_can_delete_an_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->followingRedirects();

        $this->assertDatabaseHas('articles', [
            'user_id' => $user->id,
            'title' => $article->title,
            'content' => $article->content
        ]);

        $this->delete(route('articles.destroy', [
            'article' => $article,
        ]))
            ->assertStatus(200);

        $this->assertDatabaseMissing('articles', [
            'user_id' => $user->id,
            'title' => $article->title,
            'content' => $article->content
        ]);
    }

    /** @test */
    public function user_can_update_an_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->followingRedirects();

        $this->patch(route('articles.destroy', [
            'article' => $article,
        ]), [
            'id' => $article->id,
            'title' => 'Modified title',
            'content' => 'Modified content'
        ])
            ->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'user_id' => $user->id,
            'title' => 'Modified title',
            'content' => 'Modified content'
        ]);
    }

    /** @test */
    public function user_can_get_a_page_with_all_articles()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->get(route('articles.index'))
            ->assertStatus(200)
            ->assertSee('Create new article')
            ->assertSee($article->title);
    }

    /** @test */
    public function user_can_get_a_page_with_one_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->get(route('articles.show', [
            'article' => $article
        ]))
            ->assertStatus(200)
            ->assertSee($article->title)
            ->assertSee($article->content);
    }

    /** @test */
    public function user_can_get_a_page_to_create_an_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('articles.create'))
            ->assertStatus(200)
            ->assertSee('Title')
            ->assertSee('Content')
            ->assertSee('Post');
    }

    /** @test */
    public function user_can_get_a_page_to_edit_an_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->get(route('articles.edit', [
            'article' => $article
        ]))
            ->assertStatus(200)
            ->assertSee($article->title)
            ->assertSee($article->content);
    }
}
