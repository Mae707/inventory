<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    // Optional: Define fillable fields to allow mass assignment
    protected $fillable = ['name', 'location'];

    // Optional: If your table name doesn't follow Laravel's naming convention
    // protected $table = 'warehouses';
}