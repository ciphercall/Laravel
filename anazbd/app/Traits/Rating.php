<?php

namespace App\Traits;

use App\Models\Item;

trait Rating
{

    private function Rating($id)
    {
        $Item = Item::find($id);
        dd($Item);
    }
}
