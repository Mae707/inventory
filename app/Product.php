<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    protected $fillable = ['category_id','nama','harga','image','qty','status', 'expiry_date', 'warehouse_name'];

    protected $hidden = ['created_at','updated_at'];

    protected $casts = [
    'expiry_date' => 'date',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeExpiringSoon($query)
        {
            return $query->whereDate('expiry_date', '>=', Carbon::today())
                        ->whereDate('expiry_date', '<=', Carbon::today()->addDays(7));
        }
   public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

}
