<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Call extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "calls";

    protected $fillable = [
        "partner_id",
        "mango_telnum",
        "lost_client_days",
        "repeat_client_days",
        "new_client_days",
        "pay_end",
        "tg_chat_id",
        "tg_disabled"
    ];

    public function partner(): HasOne
    {
        return $this->hasOne(Partner::class, 'id');
    }

}
