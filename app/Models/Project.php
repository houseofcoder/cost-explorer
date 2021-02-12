<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public $fillable = ['id'];
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $appends = [];
    protected $hidden = [
        'laravel_through_key',
        'title','client_id'
    ];

    public function cost()
    {
        return $this->hasMany(Cost::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
