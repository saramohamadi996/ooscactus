<?php

namespace Milano\Article\Repositories\Interfaces;

use Milano\Article\Models\Article;
use Milano\Product\Models\Product;

interface ArticleRepositoryInterface
{
    public function getById(int $id);

    public function getAll();

    public function paginate(array $input = [], int $per_page = 10);

    public function store(array $value);

    public function update(array $value, Article $article);

    public function delete(Article $article);

    public function getArticlesBySellerId(int $id);

    public function PopularArticles();
}

