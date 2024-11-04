<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UserModel;
  
class SignupController extends Controller
{
    public function index()
    {
        helper(['form']);
        $data = [];
        echo view('signup', $data);
    }

  public function store()
{
    helper(['form']);
    $rules = [
        'first_name'        => 'required|alpha|min_length[2]|max_length[50]',
        'last_name'         => 'required|alpha|min_length[2]|max_length[50]',
        'email'             => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
        'password'          => 'required|min_length[4]|max_length[50]|regex_match[/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/]',
        'confirmpassword'   => 'matches[password]'
    ];
    
    // check if session is active
    if(session()->get('isLoggedIn')) {
        //destroy session
        session_destroy();
    }

    if($this->validate($rules)){
        $userModel = new UserModel();
        //generate verification token
        $verificationToken = bin2hex(random_bytes(16));
        $data = [
            'firstName'             => $this->request->getVar('first_name'),
            'lastName'              => $this->request->getVar('last_name'),
            'email'                 => $this->request->getVar('email'),
            'userPassword'          => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'verification_token'    => $verificationToken,
            'is_verified'           => 0
        ];
        // Save the user data
        $userModel->save($data);
        $this->sendVerificationEmail($data['email'], $verificationToken);
        return redirect()->to('/signin')->with('alert', 'Registration successful.');
    }
    else{
        $data['validation'] = $this->validator;
        echo view('signup', $data);
        }
    }

    private function sendVerificationEmail($email, $token)
    {
        $emailService = \Config\Services::email();
        $emailService->setFrom('forehead614@gmail.com', 'Sauvage');
        $emailService->setTo($email);
        $emailService->setSubject('Email Verification');
        $emailService->setMessage('Please click the following link to verify your email: ' . base_url() . '/verify/' . $token);
        
        if (!$emailService->send()) {
            return redirect()->to('/signin')->with('msg', 'Email sending failed');
        }else{
            return redirect()->to('/signin')->with('msg', 'Please check your email to verify your account.');
        }
    }
    
    public function verify($token)
    {
        $userModel = new UserModel();
        $user = $userModel->where('verification_token', $token)->first();

        if ($user) {
            $userModel->update($user['userID'], ['is_verified' => 1, 'verification_token' => null]);
            return redirect()->to('/signin')->with('msg', 'Your email has been verified. You can now log in.');
        } else {
            return redirect()->to('/signin')->with('msg', 'Invalid or expired token.');
        }
    }
  
}