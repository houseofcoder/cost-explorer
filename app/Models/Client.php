<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public $fillable = ['id','name'];
    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
