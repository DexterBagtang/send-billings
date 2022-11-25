<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function composition()
    {
        return $this->belongsTo(Composition::class,'compositions_id','id');
    }

}
