<?php

namespace App\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    protected $table = 'consignment';
    public $timestamps = true;
    protected $fillable = ['tinh_trang'];
}