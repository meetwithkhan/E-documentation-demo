<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentFunction extends Model
{
    protected $table    = 'functions';
    protected $fillable = ['department_id', 'name'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'function_id');
    }
}