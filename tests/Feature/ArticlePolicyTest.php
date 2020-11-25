<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlePolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_article_author_can_view_edit_page_for_article()
    {
        $article = Article::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('articles.edit', [
            'article' => $article,
        ]))
            ->assertStatus(403);
    }

    /** @test */
    public function only_article_author_can_update_an_article()
    {
        $article = Article::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->patch(route('articles.update', [
            'article' => $article,
        ]), [
            'title' => 'Modified title',
            'content' => 'Modified content'
        ])
            ->assertStatus(403);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $article->title,
            'content' => $article->content
        ]);
    }

    /** @test */
    public function only_article_author_can_delete_an_article()
    {
        $article = Article::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->delete(route('articles.destroy', [
            'article' => $article,
        ]))
            ->assertStatus(403);

        $this->assertDatabaseHas('articles', [
            'title' => $article->title,
            'content' => $article->content,
            'deleted_at' => null
        ]);
    }
}
