<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;
    public $fillable = ['amount','id'];
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $hidden = [];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function type() {
        return $this->hasOne(costType::class,'id','cost_type_id');
    }
}
