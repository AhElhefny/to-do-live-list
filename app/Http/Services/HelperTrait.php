<?php

namespace App\Http\Services;

trait HelperTrait
{
    public function storeImage($image,$folder): string
    {
        $file = $image;
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file->move(public_path('images/'. $folder), $filename);
        return $filename;
    }
}
