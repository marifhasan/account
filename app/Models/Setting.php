<?php

namespace App\Models;

use App\HistoryTrait;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HistoryTrait;

    protected $fillable = ['name', 'value'];
}
