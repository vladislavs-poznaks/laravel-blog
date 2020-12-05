<?php

namespace App\Listeners;

use App\Events\ArticleCreated;

class UpdateArticlesCount
{
    public function handle(ArticleCreated $event)
    {
        $user = $event->article()->user;

        $user->update([
            'articles_count' => $user->articles->count()
        ]);
    }
}
