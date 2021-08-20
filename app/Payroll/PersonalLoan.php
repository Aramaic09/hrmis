<?php

namespace App\Payroll;

use Illuminate\Database\Eloquent\Model;

class PersonalLoan extends Model
{
    protected $connection = 'payroll';
    protected $table = 'view_personal_loan';
    protected $primaryKey = null;
}
