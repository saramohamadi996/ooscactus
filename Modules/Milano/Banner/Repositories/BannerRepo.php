<?php
namespace Milano\Banner\Repositories;
use Illuminate\Support\Facades\Storage;
use Milano\Banner\Models\Banner;

class BannerRepo
{
    private $query;
    public function __construct()
    {
        $this->query = Banner::query();
    }

    public function paginate()
    {
        return $this->query->latest()->paginate();
    }

    public function findByid($id)
    {
        return Banner::findOrFail($id);
    }

    public function store( $values)
    {
        if ($values->hasFile('image')) {
            $imagePath = $values->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $dir = 'baners';
            $path = $imagePath->storeAs($dir, $imageName, 'public');
        }
        return Banner::create([
            'title' => $values->title,
            'link' => $values->link,
            'image' => $path,
        ]);
    }

    public function update( $values,$id)
    {
        $banner = Banner::where('id' , $id)->firstOrFail();
        if ($values->hasFile('image')) {
            $imagePath = $values->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $dir = 'banners';
            $path = $imagePath->storeAs($dir, $imageName, 'public');

            if($banner->image){
                Storage::delete('public\\' . $banner->image);
            }
        }
        $banner->update([
            'title' => $values->title,
            'link' => $values->link,
            'image' => $path ??  $banner->image,
        ]);
        return $banner;
        }

    public function latestBanners()
    {
        return Banner::where('confirmation_status' , Banner::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(6)->get();
    }

    public function updateConfirmationStatus($id, string $confirmationStatuses)
    {
        return Banner::where('id', $id)->update(['confirmation_status'=>$confirmationStatuses]);
    }

    public function accept($id)
    {
        $banner = $this->findByid($id);
        return $banner->update(['confirmation_status' => Banner::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function reject($id)
    {
        $banner = $this->findByid($id);
        return $banner->update(['confirmation_status' => Banner::CONFIRMATION_STATUS_REJECTED]);
    }
}
