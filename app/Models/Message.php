<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = "id";
    protected $keyType = "string";
    protected $dates = [
        'time'
    ];

    public function dialog()
    {
        return $this->belongsTo(Dialog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasUser()
    {
        return $this->hasOne(User::class, 'user_id')->orderBy("time", "desc");
    }
}
