<?php
namespace Milano\Setting\Repositories;
use Illuminate\Support\Facades\Storage;
use Milano\Setting\Models\Setting;

class SettingRepo
{
    public function all()
    {
        return Setting::all();
    }
    public function store( $values)
    {
        $settings = Setting::first() ?? new Setting;
        if ($values->hasFile('logo')) {
            $logo = $values->file('logo');
            $filName = $logo->getClientOriginalName();
            $dir = 'logo';
            $logoPath = $logo->storeAs($dir, $filName, 'public');
            if($settings->logo){
                Storage::delete('public\\' . $settings->logo);
            }
        }
        if ($values->hasFile('symbol')) {
            $symbol = $values->file('symbol');
            $filName = $symbol->getClientOriginalName();
            $dir = 'symbol';
            $symbolPath = $symbol->storeAs($dir, $filName, 'public');
            if($settings->symbol){
                Storage::delete('public\\' . $settings->symbol);
            }
        }
        $settings->fill([
            'title' => $values->title,
            'mobile' => $values->mobile,
            'address' => $values->address,
            'email' => $values->email,
            'website' => $values->website,
            'telegram' => $values->telegram,
            'whatsapp' => $values->whatsapp,
            'body' => $values->body,
            'logo' => $logoPath ?? $settings->logo,
            'symbol' => $symbolPath ?? $settings->symbol,
        ]);
        $settings->save();return $settings;
    }

    public function updateConfirmationStatus($id, string $confirmationStatuses)
    {
        return Setting::where('id', $id)->update(['confirmation_status'=>$confirmationStatuses]);
    }

    public function create()
    {
        return $settings = Setting::first() ?? new Setting;

    }
}
