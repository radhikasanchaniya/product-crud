<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait DatatableTrait
{
    public function image($exist, $width = '20%')
    {
        if (is_null($exist) || !Storage::exists($exist)) {
            $img_url =  asset('assets/images/default/default-image.png');
        }

        if (!is_null($exist) && Storage::exists($exist)) {
            $img_url =  asset('storage/' . $exist);
        }

        return '
            <div>
                <img src="' . $img_url . '" style="width:' . $width . '" alt="">
            </div>
        ';
    }

    public function action($data)
    {
        return view('components.action')->with('list_item', $data)->render();
    }
}
