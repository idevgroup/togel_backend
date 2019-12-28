<?php

namespace App\Models\BackEnd;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BankGroup extends Model
{
    use LogsActivity;
    protected static $logFillable = true;
    protected $table = 'bank_group';
    
}
