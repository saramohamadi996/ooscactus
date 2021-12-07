<?php

namespace Milano\Article\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Milano\Article\Models\Article;
use Milano\Product\Models\Product;

interface ArticleRepositoryInterface
{
    /**
     *  get articles by seller id.
     * @param int $id
     * @return mixed
     */
    public function getArticlesBySellerId(int $id);

    /**
     * show popular active articles.
     * @return mixed
     */
    public function PopularArticles();

    /**
     *  paginate articles.
     * @param array $input
     * @param int $per_page
     * @return LengthAwarePaginator
     */
    public function paginate(array $input = [], int $per_page = 10): LengthAwarePaginator;

    /**
     * returns all articles.
     * @return Builder[]|Collection
     */
    public function getAll(): Collection;

    /**
     * returns an instance of product model according to given id
     * @param int $id
     * @return Article|Builder|Builder[]|Collection|Model
     */
    public function getById(int $id):Article;

    /**
     * Store a newly created resource in storage.
     * @param array $value
     * @return bool
     */
    public function store(array $value): bool;

    /**
     * Update the specified resource in storage.
     * @param array $value
     * @param Article $article
     * @return bool
     */
    public function update(array $value, Article $article): bool;

    /**
     * Remove the specified resource from storage.
     * @param Article $article
     * @return bool
     */
    public function delete(Article $article): bool;
}

