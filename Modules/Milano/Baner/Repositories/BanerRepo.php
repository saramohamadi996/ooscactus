<?php
namespace Milano\Baner\Repositories;
use Illuminate\Support\Facades\Storage;
use Milano\Baner\Models\Baner;

class BanerRepo
{
    private $query;
    public function __construct()
    {
        $this->query = Baner::query();
    }

    public function paginate()
    {
        return $this->query->latest()->paginate();
    }

    public function findByid($id)
    {
        return Baner::findOrFail($id);
    }

    public function store( $values)
    {
        if ($values->hasFile('image')) {
            $imagePath = $values->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $dir = 'baners';
            $path = $imagePath->storeAs($dir, $imageName, 'public');
        }
        return Baner::create([
            'title' => $values->title,
            'link' => $values->link,
            'image' => $path,
        ]);
    }

    public function update( $values,$id)
    {
        $baner = Baner::where('id' , $id)->firstOrFail();
        if ($values->hasFile('image')) {
            $imagePath = $values->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $dir = 'baners';
            $path = $imagePath->storeAs($dir, $imageName, 'public');

            if($baner->image){
                Storage::delete('public\\' . $baner->image);
            }
        }
        $baner->update([
            'title' => $values->title,
            'link' => $values->link,
            'image' => $path ??  $baner->image,
        ]);
        return $baner;
        }

    public function latestBaners()
    {
        return Baner::where('confirmation_status' , Baner::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(6)->get();
    }

    public function updateConfirmationStatus($id, string $confirmationStatuses)
    {
        return Baner::where('id', $id)->update(['confirmation_status'=>$confirmationStatuses]);
    }

    public function accept($id)
    {
        $baner = $this->findByid($id);
        return $baner->update(['confirmation_status' => Baner::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function reject($id)
    {
        $baner = $this->findByid($id);
        return $baner->update(['confirmation_status' => Baner::CONFIRMATION_STATUS_REJECTED]);
    }
}
