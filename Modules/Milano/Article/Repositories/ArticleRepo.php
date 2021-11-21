<?php
namespace Milano\Article\Repositories;
use Illuminate\Support\Facades\Storage;
use Milano\Article\Models\Article;
use Illuminate\Support\Str;

class ArticleRepo
{
    private $query;
    public function __construct()
    {
        $this->query = Article::query();
    }

    public function findByid($id)
    {
        return Article::findOrFail($id);
    }

    public function searchTitle($title)
    {
        if (!is_null($title)) {
            $this->query->where("title", "like", "%" .  $title . "%");
        }return $this;
    }

    public function searchCategoryId($categoryId)
    {
        $this->query->when($categoryId, function ($query) use ($categoryId) {
            return $query->whereHas("categories", function ($q) use ($categoryId) {
                return $q->where("categories.title", "like", "%{$categoryId}%");
            });
        });return $this;
    }

    public function paginate()
    {
        return $this->query->latest()->paginate();
    }

   public function store($values)
    {
        if ($values->hasFile('image')) {
            $imagePath = $values->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $dir = 'articles';
            $path = $imagePath->storeAs($dir, $imageName, 'public');
        }
        return Article::create([
            'title' => $values->title,
            'slug' =>$values->slug,
            'body' => $values->body,
            'image' => $path,
            'user_id' => auth()->id(),
        ]);
    }

    public function update($id, $values)
    {
        $article = Article::where('id' , $id)->firstOrFail();
        if ($values->hasFile('image')) {
            $imagePath = $values->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $dir = 'articles';
            $path = $imagePath->storeAs($dir, $imageName, 'public');
            if ($article->image) {
                Storage::delete('public\\' . $article->image);
            }
        }
        $article->update([
            'title' => $values->title,
            'slug' =>$values->slug,
            'body' => $values->body,
            'image' => $path ?? $article->image,
            'user_id' => auth()->id(),
        ]);
        $article->categories()->sync($values->category_id);
        return $article;
    }

    public function updateConfirmationStatus($id, string $confirmationStatuses)
    {
        return $this->query->where("id" , $id )->update(['confirmation_status'=>$confirmationStatuses]);
    }

    public function accept($id)
    {
        $article = $this->findByid($id);
        return $article->update(['confirmation_status' => Article::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function reject($id)
    {
        $article = $this->findByid($id);
        return $article->update(['confirmation_status' => Article::CONFIRMATION_STATUS_REJECTED]);
    }

    public function getArticlesBySellerId(?int $id)
    {
        return Article::where('user_id', $id)->get();
    }

    public function PopularArticles()
    {
        return Article::where('confirmation_status' , Article::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(6)->get();
    }
}
