<?php

namespace App;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'birth_date', 'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAge(){
        return $age = Carbon::parse($this->birth_date)->age;
    }
}
