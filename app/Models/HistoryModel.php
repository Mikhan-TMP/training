<?php

namespace App\Models; 
use CodeIgniter\Model;
 
class HistoryModel extends Model{
 protected $table = 'login_history';
 
 protected $allowedFields = [
    'userID',
    'loginTime',
    'logoutTime',
    'ipAddress'
 ];
}

