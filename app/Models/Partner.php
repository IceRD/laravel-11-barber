<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "partners";

    protected $fillable = [
        "organization",
        "inn",
        "name",
        "contract_number",
        "email",
        "telnums",
        "address",
        "start_at",
        "yclients_id",
        "disabled"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function call(): BelongsTo
    {
        return $this->belongsTo(Call::class);
    }
}
