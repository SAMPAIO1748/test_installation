<?php

namespace App\Globals;

use App\Repository\ArticleRepository;

class Articles
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getAll()
    {
        $arts = $this->articleRepository->findAll();

        return $arts;
    }
}
