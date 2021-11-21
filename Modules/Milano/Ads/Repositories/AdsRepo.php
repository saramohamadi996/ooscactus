<?php
namespace Milano\Ads\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Milano\Ads\Models\Ads;

class AdsRepo
{
    private $query;
    public function __construct()
    {
        $this->query = Ads::query();
    }

    public function paginate()
    {
        return $this->query->latest()->paginate();
    }

    public function findByid($id)
    {
        return Ads::findOrFail($id);
    }

    public function store( $values)
    {
        if ($values->hasFile('image')){
            $imagePath = $values->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $dir = 'adss';
            $path = $imagePath->storeAs($dir, $imageName, 'public');
        }
        return Ads::create([
        'title' => $values->title,
        'page' => $values->page,
        'ads' => $values->ads,
        'start_at' => $values->start_at,
        'expired_at' => $values->expired_at,
        'link' => $values->link,
        'opening' => $values->opening,
        'image' =>$path,
        ]);
    }

    public function update( $values,$id)
    {
        $adss = Ads::where('id' , $id)->firstOrFail();
        if ($values->hasFile('image')) {
            $imagePath = $values->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $dir = 'adss';
            $path = $imagePath->storeAs($dir, $imageName, 'public');

            if($adss->image){
                Storage::delete('public\\' . $adss->image);
            }
        }
      $adss->update([
            'title' => $values->title,
            'page' => $values->page,
            'ads' => $values->ads,
          'start_at' => $values->start_at,
          'expired_at' => $values->expired_at,
            'link' => $values->link,
            'opening' => $values->opening,
            'image' => $path ??  $adss->image,
        ]);return $adss;
    }

    public function updateConfirmationStatus($id, string $confirmationStatuses)
    {
        return Ads::where('id', $id)->update(['confirmation_status'=>$confirmationStatuses]);
    }

    public function accept($id)
    {
        $adss = $this->findByid($id);
        return $adss->update(['confirmation_status' => Ads::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function reject($id)
    {
        $adss = $this->findByid($id);
        return $adss->update(['confirmation_status' => Ads::CONFIRMATION_STATUS_REJECTED]);
    }
}
