<?php

namespace App\Model;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use Orderable;

    protected $fillable = ['body'];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
