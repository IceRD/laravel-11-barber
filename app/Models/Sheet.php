<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sheet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sheets';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'title',
        'spreadsheet_id',
        'spreadsheet_name',
        'spreadsheet_range',
        'slug',
        'table_header',
        'disabled',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(Sheet::class, 'sheet_id');
    }
}
