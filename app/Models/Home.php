<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'street',
        'district',
        'city',
        'floor',
        'how_many_rooms',
        'total_area',
        'ceiling_height',
        'how_many_flors',
        'how_many_flors_house',
        'year_of_construction',
        'type',
        'type_ob_transaction',
        'type_of_house',
        'condition',
        'description',
        'images',
        'seller_id',

    ];
}
