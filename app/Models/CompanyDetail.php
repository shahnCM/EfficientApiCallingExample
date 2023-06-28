<?php

namespace App\Models;

use App\Notifications\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CompanyDetail extends Model
{
    use HasFactory;
    protected $table = 'company_details';
    protected $fillable = ['symbol', 'email', 'start_date', 'end_date'];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            Notification::route('mail', $item->email)->notify(new Mail($item));
        });
    }
}
