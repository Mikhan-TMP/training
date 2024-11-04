<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HistoryModel;
class APIController extends BaseController
{

    protected $sessionTimeout = 60; // 1 minute
    public function index()
    {
        $this->checkSessionTimeout();
        $session = session();
        if ($session->has('isLoggedIn') && $session->get('isLoggedIn')) {
            $userModel = new UserModel();
            $historyModel = new HistoryModel();
            // $data['users'] = $userModel->findAll();
            $data['histories'] = $historyModel->where('userID', $session->get('id'))->findAll();
            return view('userdashboard', $data);
        }else{
            return redirect()->to('/signin');
        }
    }

    public function changePassword(){
        $this->checkSessionTimeout();
        //check the inputs if they are filled
        if  (empty($this->request->getVar('currentPassword')) || 
            empty($this->request->getVar('newPassword')) || 
            empty($this->request->getVar('confirmPassword')) )
        {
            return redirect()->back()->with('error', 'Please fill all the fields.');
        }
        //check the input fields are valid format that has letters and numbers and special characters with no spaces
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/', $this->request->getVar('currentPassword'))) {
            return redirect()->back()->with('error', 'Your old password contains at least one letter, one number, one special character, and no spaces.');
        }
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/', $this->request->getVar('newPassword'))) {
            return redirect()->back()->with('error', 'Password must contain at least one letter, one number, one special character, and no spaces.');
        }
        //check if the new password and confirm password match
        if ($this->request->getVar('newPassword') !== $this->request->getVar('confirmPassword')) {
            return redirect()->back()->with('error', 'New password and confirm password do not match.');
        }
        
        $session = session();
        if ($session->has('isLoggedIn') && $session->get('isLoggedIn')) {
            $userModel = new UserModel();
            $userId = $session->get('id');

            $currentPassword = $this->request->getVar('currentPassword');
            $newPassword = $this->request->getVar('newPassword');
            $confirmPassword = $this->request->getVar('confirmPassword');

            $user = $userModel->where('userID', $session->get('id'))->find();
            
            if (!$user || !password_verify($currentPassword, $user[0]['userPassword'])) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }
            $userModel->update($userId, ['userPassword' => password_hash($newPassword, PASSWORD_DEFAULT)]);

            return redirect()->back()->with('success', 'Password updated successfully.');
        }
        else{
            return redirect()->to('/signin');
        }
    }

    public function editProfile(){
        $this->checkSessionTimeout();
        $session = session();
        // check the inputs if they are filled
        if  (empty($this->request->getVar('username')) || 
            empty($this->request->getVar('firstname')) || 
            empty($this->request->getVar('lastname')) || 
            empty($this->request->getVar('phone')) || 
            empty($this->request->getVar('dob')) || 
            empty($this->request->getVar('gender')) )
        {
            return redirect()->back()->with('error', 'Please fill all the fields.');
        }
        //check if the input fields are valid
        if (!preg_match('/^[a-zA-Z0-9]+$/', $this->request->getVar('username'))) {
            return redirect()->back()->with('error', 'Username can only contain letters and numbers.');
        }
        //username should only have 2-50 characters
        if (strlen($this->request->getVar('username')) < 2 || strlen($this->request->getVar('username')) > 50) {
            return redirect()->back()->with('error', 'Username must be between 2 and 50 characters.');
        }
        if (!preg_match('/^[a-zA-Z]{2,50}+$/', $this->request->getVar('firstname')) || !preg_match('/^[a-zA-Z]{2,50}+$/', $this->request->getVar('lastname'))) {
            return redirect()->back()->with('error', 'First name and last name can only contain letters and be at least 2 characters.');
        }
        if (!preg_match('/^\d{11}$/', $this->request->getVar('phone'))) {
            return redirect()->back()->with('error', 'Phone number must be 11 digits.');
        }
        if (!preg_match('/^(19|20)\d\d-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/', $this->request->getVar('dob'))) {
            return redirect()->back()->with('error', 'Date of birth must be in the format YYYY-MM-DD.');
        }
        if (!preg_match('/^(Male|Female|Other)$/', $this->request->getVar('gender'))) {
            return redirect()->back()->with('error', 'Gender must be male or female.');
        }
        
        //check if the user is logged in
        if ($session->has('isLoggedIn') && $session->get('isLoggedIn')) {
            $userModel = new UserModel();
            $userId = $session->get('id');

            $data = [
                // 'image' => $imageData,
                'userName' => $this->request->getVar('username'),
                'firstName' => $this->request->getVar('firstname'),
                'lastName' => $this->request->getVar('lastname'),
                'phoneNumber' => $this->request->getVar('phone'),
                'birthDate' => $this->request->getVar('dob'),
                'gender' => $this->request->getVar('gender')
            ];
    
            if($session->get('image') == null){
                $file = $this->request->getFile('image');
                $imageData = null;
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $imageData = file_get_contents($file->getTempName());
                }
                //add image to $data
                $data['image'] = $imageData;
            }
            // Update user data in the database
            $updateSuccess = $userModel->update($userId, $data);
            $datas = $userModel->where('userID', $userId)->first();
            // Convert the BLOB image to a Base64 string if it exists
            $imageData = !empty($datas['image']) ? base64_encode($datas['image']) : null;
            // Retrieve the existing session data to preserve crucial fields
            $currentSessionData = [
                'isLoggedIn' => $session->get('isLoggedIn'),
                'loginTime' => $session->get('loginTime'),
                'ipAddress' => $session->get('ipAddress')
            ];

            // Prepare only the updated fields for merging
            $updateData = [
                'image' => $imageData,
                'id' => $datas['userID'],
                'name' => $datas['firstName'] . ' ' . $datas['lastName'],
                'firstname' => $datas['firstName'],
                'username' => $datas['userName'],
                'lastname' => $datas['lastName'],
                'gender' => $datas['gender'],
                'phone' => $datas['phoneNumber'],
                'birthdate' => $datas['birthDate'],
                'email' => $datas['email'],
                'role' => $datas['role'],
                'password' => $datas['userPassword']
            ];
            // Merge the preserved session data with the new updates
            $session->set(array_merge($currentSessionData, $updateData));
    
            return redirect()->back()->with('success', 'Profile updated successfully.');
        }
        return redirect()->to('/signin');
    }
    private function checkSessionTimeout()
    {
        $session = session();

        if ($session->has('lastActivity')) {
            $elapsedTime = time() - $session->get('lastActivity');

            if ($elapsedTime >= $this->sessionTimeout) {
                // Session has expired
                $session->destroy();
                return redirect()->to('/signin')->with('error', 'Session timed out. Please log in again.');
            } else {
                // Update last activity time if session is still active
                $session->set('lastActivity', time());
            }
        }
    }

}
