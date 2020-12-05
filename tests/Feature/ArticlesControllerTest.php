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
    public function user_can_soft_delete_an_article()
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

        $this->assertSoftDeleted('articles', [
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

        $this->patch(route('articles.update', [
            'article' => $article,
        ]), [
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

    /** @test */
    public function guest_cannot_view_article_create_page()
    {
        $this->get(route('articles.create'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_create_article()
    {
        $this->post(route('articles.store'), [
            'title' => 'Test Title',
            'content' => 'Test Content'
        ])
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_view_article_edit_article()
    {
        $article = Article::factory()->create();

        $this->get(route('articles.edit', [
            'article' => $article
        ]))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_update_article()
    {
        $article = Article::factory()->create();

        $this->patch(route('articles.update', [
            'article' => $article
        ]), [
            'title' => 'Modified title',
            'content' => 'Modified content'
        ])
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_delete_article()
    {
        $article = Article::factory()->create();

        $this->delete(route('articles.destroy', [
            'article' => $article,
        ]))
            ->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('articles', [
            'title' => $article->title,
            'content' => $article->content
        ]);
    }

    /** @test */
    public function article_owner_can_not_be_overwritten()
    {
        $user = User::factory()->create([
            'id' => 1
        ]);
        $this->actingAs($user);

        $this->followingRedirects();

        $this->post(route('articles.store'), [
            'user_id' => 2,
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
    public function article_count_is_updated_when_article_is_created()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        //$this->followingRedirects();

        $this->post(route('articles.store'), [
            'title' => 'Test Title',
            'content' => 'Test Content'
        ]);

        $this->assertDatabaseHas('users', [
           'id' => $user->id,
           'articles_count' => 1
        ]);

        $this->assertEquals(1, $user->refresh()->articles_count);
    }
}
