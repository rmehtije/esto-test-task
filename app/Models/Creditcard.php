<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creditcard extends Model
{
    public $table = 'credit_card';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'credit_card',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
