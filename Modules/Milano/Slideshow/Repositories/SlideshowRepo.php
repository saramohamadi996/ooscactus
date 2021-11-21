<?php
namespace Milano\Slideshow\Repositories;
use Illuminate\Support\Facades\Storage;
use Milano\Slideshow\Models\Slideshow;

class SlideshowRepo
{
    private $query;
    public function __construct()
    {
        $this->query = Slideshow::query();
    }

    public function paginate()
    {
        return $this->query->latest()->paginate();
    }

    public function findByid($id)
    {
        return Slideshow::findOrFail($id);
    }

    public function store( $values)
    {
        if ($values->hasFile('image')) {
            $imagePath = $values->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $dir = 'slideshows';
            $path = $imagePath->storeAs($dir, $imageName, 'public');
        }
        return Slideshow::create([
            'title' => $values->title,
            'link' => $values->link,
            'image' => $path,
        ]);
    }

    public function update( $values,$id)
    {
        $slideshow = Slideshow::where('id' , $id)->firstOrFail();
        if ($values->hasFile('image')) {
            $imagePath = $values->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $dir = 'slideshows';
            $path = $imagePath->storeAs($dir, $imageName, 'public');

            if($slideshow->image){
                Storage::delete('public\\' . $slideshow->image);
            }
        }
        $slideshow->update([
            'title' => $values->title,
            'link' => $values->link,
            'image' => $path ??  $slideshow->image,
        ]);
        return $slideshow;
        }

    public function latestSlideshows()
    {
        return Slideshow::where('confirmation_status' , Slideshow::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(6)->get();
    }

    public function updateConfirmationStatus($id, string $confirmationStatuses)
    {
        return Slideshow::where('id', $id)->update(['confirmation_status'=>$confirmationStatuses]);
    }

    public function accept($id)
    {
        $slideshow = $this->findByid($id);
        return $slideshow->update(['confirmation_status' => Slideshow::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function reject($id)
    {
        $slideshow = $this->findByid($id);
        return $slideshow->update(['confirmation_status' => Slideshow::CONFIRMATION_STATUS_REJECTED]);
    }
}
