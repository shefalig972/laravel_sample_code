<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;

class EmployeePool extends Authenticatable {

    use Notifiable,
        HasApiTokens;

    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'usertype', 'gender', 'user_language', 'phone_number', 'parent_id', 'status'];

    use Sortable;

    public $sortable = ['id', 'firstname', 'lastname', 'email', 'phone_number'];
    protected $hidden = ['password', 'remember_token'];

    /**
     * @method:      getFullNameAttribute
     * @params:      []
     * @createddate: 10-03-2019 (dd-mm-yyyy)
     * @developer:   Varun
     * @purpose:     to concat the firstname and lastname
     * @return:      []
     */
    public function getFullNameAttribute($value) {
        return "{$this->firstname} {$this->lastname}";
    }

}
