<?php

namespace App\Payroll;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    protected $connection = 'payroll';
    protected $table = 'view_deduction';
    protected $primaryKey = null;
}
