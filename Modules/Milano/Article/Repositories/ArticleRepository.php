<?php

namespace Milano\Article\Repositories;

use Milano\Article\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Milano\Article\Models\Article;
use Milano\Product\Models\Product;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     *  get articles by seller id.
     * @param int $id
     * @return mixed
     */
    public function getArticlesBySellerId(int $id)
    {
        return Article::where('user_id', $id)->get();
    }

    /**
     * show popular active articles.
     * @return mixed
     */
    public function PopularArticles()
    {
        return Article::where('is_enabled')->latest()->take(6)->get();
    }

    /**
     * fetch query builder articles.
     * @param array $input
     * @return Builder
     */
    private function fetchQueryBuilder(array $input = []): Builder
    {
        return Article::query()
            ->when(isset($input['title']), function (Builder $query) use ($input) {
                $query->where('title', 'like', '%' . $input['title'] . '%');
            })
            ->when(isset($input['category_id']), function (Builder $query) use ($input) {
                $query->where('category_id', '=', $input['category_id']);
            });
    }

    /**
     *  paginate articles.
     * @param array $input
     * @param int $per_page
     * @return LengthAwarePaginator
     */
    public function paginate(array $input = [], int $per_page = 10): LengthAwarePaginator
    {
        return $this->fetchQueryBuilder($input)->paginate($per_page);
    }

    /**
     * returns all articles.
     * @return Builder[]|Collection
     */
    public function getAll(): Collection
    {
        return $this->fetchQueryBuilder()->get();
    }

    /**
     * returns an instance of product model according to given id
     * @param int $id
     * @return Article |Builder|Builder[]|Collection|Model
     */
    public function getById(int $id):Article
    {
        return $this->fetchQueryBuilder()->findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     * @param array $value
     * @return bool
     */
    public function store(array $value): bool
    {
        $article = new Article;
        $article->title = $value['title'];
        $article->slug = Str::slug($value['slug']);
        $article->body = $value['body'];
        $article->user_id = auth()->id();
        $article->image = $value['image'];
        try {
            if ($article->save()) {
                $category_id = $value['category_id'];
                $article->categories()->sync($category_id);
            }
        } catch (QueryException $query_exception) {
            Log::error($query_exception->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Update the specified resource in storage.
     * @param array $value
     * @param Article $article
     * @return bool
     */
    public function update(array $value, Article $article): bool
    {
        if (isset($value['title'])) {
            $article->title = $value['title'];
        }
        if (isset($value['slug'])) {
            $article->slug = Str::slug($value['slug']);
        }
        if (isset($value['body'])) {
            $article->body = $value['body'];
        }
        if (isset($value['user_id'])) {
            $article->user_id = auth()->id();
        }
        if (isset($value['image'])) {
            $article->image = $value['image'];
        }
        if (isset($value['is_enabled'])) {
            $article->is_enabled = $value['is_enabled'];
        }
        try {
            if ($article->save()) {
                $category_id = $value['category_id'];
                $article->categories()->sync($category_id);
            }
        } catch (QueryException $query_exception) {
            Log::error($query_exception->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     * @param Article $article
     * @return bool
     */
    public function delete(Article $article): bool
    {
        try {
            $article->delete();
        } catch (QueryException $query_exception) {
            Log::error($query_exception->getMessage());
            return false;
        }
        return true;
    }

}
