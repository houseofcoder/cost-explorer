<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CostType extends Model
{
    use HasFactory;
    public $fillable = ['id','name'];
    protected $table = 'cost_types';
    public $timestamps = false;

    protected $hidden = [
        'laravel_through_key',
    ];

    public function childs() {
        return $this->hasMany(CostType::class,'parent_id','id');
    }

    public function childrenCostType()
    {
        return $this->hasMany(CostType::class,'parent_id','id')->with('childs');
    }

    public function cost()
    {
        return $this->hasMany(Cost::class);
    }
}
