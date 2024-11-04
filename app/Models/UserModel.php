<?php 
namespace App\Models; 
use CodeIgniter\Model;
 
class UserModel extends Model{
//  protected $table = 'user_tbl';
protected $table = 'users';
protected $primaryKey = 'userID';
 protected $allowedFields = [
 'id',
 'image',
 'firstName',
 'lastName',
 'userName',
 'phoneNumber',
 'gender',
 'birthDate',
 'email',
 'userPassword',
 'verification_token',
 'is_verified'
 ];
}

