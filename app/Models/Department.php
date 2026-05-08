<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

    public function functions()
    {
        return $this->hasMany(DepartmentFunction::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}