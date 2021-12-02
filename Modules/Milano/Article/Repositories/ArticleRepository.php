<?php

namespace Milano\Article\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Milano\Article\Models\Article;
use Milano\Article\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    private function fetchQueryBuilder(array $input = []): Builder
    {
        return Article::query()
            ->when(isset($input['title']), function (Builder $query) use ($input) {
                $query->orWhere('title', 'like', '%' . $input['title'] . '%');
            })
            ->when(isset($input['category_id']), function (Builder $query) use ($input) {
                $query->where('category_id', '=', $input['category_id']);
            });
    }

    public function getById(int $id)
    {
        return $this->fetchQueryBuilder()->findOrFail($id);
    }

    public function getAll()
    {
        return $this->fetchQueryBuilder()->get();
    }

    public function paginate(array $input = [], int $per_page = 10)
    {
        return $this->fetchQueryBuilder($input)->paginate($per_page);
    }

    public function store(array $value)
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

    public function update(array $value, int $id)
    {
        // TODO: Implement update() method.
    }

    public function delete(Article $article)
    {
        try {
            $article->delete();
        } catch (QueryException $query_exception) {
            Log::error($query_exception->getMessage());
            return false;
        }
        return true;
    }

    public function getArticlesBySellerId(int $id)
    {
        return Article::where('user_id', $id)->get();
    }

    public function PopularArticles()
    {
        return Article::where('is_enabled')->latest()->take(6)->get();
    }
}
