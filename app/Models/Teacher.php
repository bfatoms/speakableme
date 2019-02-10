<?php

namespace App\Models;

use App\Models\User;

class Teacher extends User
{
    public function __construct()
    {
        parent::__construct();
        $this->fillable = array_merge($this->fillable, [
            'peak1to15', 'peak16to31', 'special_plotting_indefinite', 
            'special_plotting', 'teacher_account_type_id', 'bank_name',
            'bank_account_number', 'bank_account_name', 'base_rate'
        ]);

        $this->hidden = array_merge($this->hidden, [
            'immortal', 'student_account_type_id', 'trial_balance', 'trial_validity'
        ]);
    }
}
