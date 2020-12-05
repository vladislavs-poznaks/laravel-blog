<?php

namespace App\Events;

use App\Models\Article;

class ArticleCreated
{
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function article(): Article
    {
        return $this->article;
    }
}
