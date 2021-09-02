<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use HasFactory;
    use Sortable;

    protected $guarded = [
        'id',
    ];

    public $sortable = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    public static $rules = [
        'name' => 'required',
    ];

    public function event() {
        return $this->hasMany('App\Models\Event', 'category_id');
    }
}
