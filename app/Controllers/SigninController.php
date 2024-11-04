<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\HistoryModel;
date_default_timezone_set('Asia/Manila'); //error on the IP if uncommented

class SigninController extends Controller
{

    public function index()
    {
        helper(['form']);
        echo view('signin');
    } 
  
    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $userModel->where('email', $email)->first();
        $imageData = !empty($data['image']) ? base64_encode($data['image']) : null;
        if($data){
            $pass = $data['userPassword'];
            $authenticatePassword = password_verify($password, $pass);
            if($authenticatePassword){
                $ses_data = [
                    'id' => $data['userID'],
                    'image' => $imageData,
                    'name' => $data['firstName'] . ' ' . $data['lastName'],
                    'username' => $data['userName'],
                    'firstname' => $data['firstName'],
                    'lastname' => $data['lastName'],
                    'gender' => $data['gender'],
                    'phone' => $data['phoneNumber'],
                    'birthdate' => $data['birthDate'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                    // 'password' => $data['userPassword'],
                    'isLoggedIn' => TRUE , 
                    'loginTime' => date('Y-m-d H:i:s'),
                    'ipAddress' => file_get_contents('https://api.ipify.org'),
                    'isVerified' => $data['is_verified'],
                ];
                $session->set($ses_data);

                $session->setFlashdata('msg', 'Login Successfully');
                return redirect()->to('/');
            
            }else{
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/signin');
            }
        }else{
            $session->setFlashdata('msg', 'User does not exist.');
            return redirect()->to('/signin');
        }
    }
  
    public function logout()
    {
        $session = session();
        if ($session->has('isLoggedIn') && $session->get('isLoggedIn')) {
            $historyModel = new HistoryModel();
            $historyModel->insert([
                'userID' => $session->get('id'),
                'loginTime' => $session->get('loginTime'),
                'logoutTime' => date('Y-m-d H:i:s'),
                'ipAddress' => $session->get('ipAddress')
            ]);
            $session = session();
            $session->destroy();
            return redirect()->to('/');
        }else{
            return redirect()->to('/signin');
        }

        // return redirect()->to('/');
    }
}