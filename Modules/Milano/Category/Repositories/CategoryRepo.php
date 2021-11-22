<?php
namespace Milano\Category\Repositories;
use Milano\Category\Models\Category;
use Milano\Product\Models\Product;

class CategoryRepo
{
    public function all(){
        return Category::all();
    }

    public function allExceptById($id)
    {
        return $this->all()->filter(function ($item) use ($id) {
            return $item->id != $id;
        });
    }

    public function findById($id)
    {
        return Category::findOrFail($id);
    }

    public function store($values)
    {
        return Category::create([
            'title' =>$values->title,
            'slug' =>$values->slug,
            'parent_id' =>$values->parent_id,
        ]);
    }

    public function update($id, $values)
    {
        Category::where('id', $id)->update([
            'title' => $values->title,
            'slug' => $values->slug,
            'parent_id' => $values->parent_id,
        ]);
    }

    public function delete($id)
    {
        Category::where('id', $id)->delete();
    }

    public function tree()
    {
        return Category::where('parent_id', null)->with('subCategories')->get();
    }
    public function latestProducts()
    {
        return Product::where('confirmation_status',
            Product::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(8)->get();
    }
}
