<?php
namespace Milano\Contact\Repositories;
use Illuminate\Support\Facades\Storage;
use Milano\Seller\Models\Seller;

class SellerRepo
{
    public function all(){
        return Seller::all();
    }

    public function findByid($id)
    {
        return Seller::findOrFail($id);
    }

    public function store( $values,$id)
    {
        $sellers = Seller::where('id' , $id)->firstOrFail();
        if ($values->hasFile('image1')) {
        $image1 = $values->file('image1');
        $filName = $image1->getClientOriginalName();
        $dir = 'image1';
        $image1Path = $image1->storeAs($dir, $filName, 'public');
        if($sellers->image1){
        Storage::delete('public\\' . $sellers->image1);
          }
        }
        if ($values->hasFile('image2')) {
            $image2 = $values->file('image2');
            $filName = $image2->getClientOriginalName();
            $dir = 'image2';
            $image2Path = $image2->storeAs($dir, $filName, 'public');
            if($sellers->image2){
                Storage::delete('public\\' . $sellers->image2);
            }
        }
        if ($values->hasFile('image3')) {
            $image3 = $values->file('image3');
            $filName = $image3->getClientOriginalName();
            $dir = 'image3';
            $image3Path = $image3->storeAs($dir, $filName, 'public');
            if($sellers->image3){
                Storage::delete('public\\' . $sellers->image3);
            }
        }
//        $sellers->fill([
            $sellers->update([
            'percent' => $values->percent,
            'price' => $values->price,
            'payment' => $values->payment,
            'telegram' => $values->telegram,
            'titre' => $values->titre,
            'title1' => $values->title1,
            'title2' => $values->title2,
            'title3' => $values->title3,
            'title' => $values->title,
            'head1' => $values->head1,
            'head2' => $values->head2,
            'head3' => $values->head3,
            'product' => $values->product,
            'standard' => $values->standard,
            'rules' => $values->rules,
            'image1' => $image1Path ?? $sellers->image1,
            'image2' => $image2Path ?? $sellers->image2,
            'image3' => $image3Path ?? $sellers->image3,
        ]);
        $sellers->save();
        return $sellers;
    }

    public function updateStatus($id, string $confirmationStatuses)
    {
        return Seller::where('id', $id)->update(['confirmation_status'=>$confirmationStatuses]);
    }

    public function accept($id)
    {
        $sellers = $this->findByid($id);
        return $sellers->update(['confirmation_status' => Seller::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function reject($id)
    {
        $sellers = $this->findByid($id);
        return $sellers->update(['confirmation_status' => Seller::CONFIRMATION_STATUS_REJECTED]);
    }
}
