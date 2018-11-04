<?php

namespace App\Model;

use App\Traits\Orderable;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use Orderable;

    protected $fillable = ['body'];

    /**
     * 所有しているmessageableモデルの全取得
     */
    public function messageable()
    {
        return $this->morphTo();
    }

    // 投稿者
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
