<?php

namespace App\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = ['tinh_trang', 'khoi_luong'];
}
