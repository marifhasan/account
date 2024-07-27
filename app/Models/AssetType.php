<?php

namespace App\Models;

use App\HistoryTrait;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    use HistoryTrait;

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
