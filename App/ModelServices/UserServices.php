<?php

namespace App\ModelServices;

use App\Models\User;
use App\Helpers\Validation;
use App\Helpers\Sanitizer;
use App\FileServices\UploadService;

class UserServices
{
    public function register(array $input): array
    {
        $validation = new Validation();

        $rules = [
            'firstname'         => 'required|min:2|max:50|xssSafe',
            'lastname'          => 'required|min:2|max:50|xssSafe',
            'username'          => 'required|min:3|max:20|allowedChars:/^[a-zA-Z0-9_]+$/|unique:users,username',
            'email'             => 'required|email|unique:users,email',
            'phone'             => 'optional|max:20',
            'role'              => 'required|in:admin,user,editor',
            'main_job'          => 'optional|max:100',
            'birthdate'         => 'required|date',
            'gender'            => 'required|in:male,female,other',
            'password'          => 'required|min:8|max:255',
            'confirm_password'  => 'required|matches:password',
        ];

        if (!$validation->validate($input, $rules)) {
            return ['success' => false, 'errors' => $validation->errors()];
        }

        $user = new User();
        $user->firstname  = Sanitizer::sanitizeString($input['firstname']);
        $user->lastname   = Sanitizer::sanitizeString($input['lastname']);
        $user->phone      = Sanitizer::sanitizeString($input['phone'] ?? '');
        $user->email      = Sanitizer::sanitizeEmail($input['email']);
        $user->username   = Sanitizer::sanitizeString($input['username']);
        $user->role       = $input['role'];
        $user->main_job   = Sanitizer::sanitizeString($input['main_job'] ?? '');
        $user->birthdate  = $input['birthdate'];
        $user->gender     = $input['gender'];
        $user->password   = $input['password'];

        // File upload
        if (!empty($_FILES['img']['name'])) {
            $uploadedFile = UploadService::uploadFile('users', 'img', ['image/jpeg', 'image/png', 'image/gif'], 2 * 1024 * 1024);
            $user->img = 'users/' . $uploadedFile;

            if ($uploadedFile === false) {
                return ['success' => false, 'errors' => ['img' => ['Failed to upload profile image.']]];
            }
            $user->img = 'users/' . $uploadedFile;
        }

        if (!$user->store()) {
            return ['success' => false, 'errors' => ['system' => ['Failed to register user. Try again later.']]];
        }

        return ['success' => true];
    }

    public function authenticate(array $input): array
    {
        $validation = new Validation();
        $rules = [
            'usernameOrEmail' => 'required|min:3|max:255', // accepts email or username
            'password'        => 'required|min:8',
        ];
    
        if (!$validation->validate($input, $rules)) {
            return ['success' => false, 'errors' => $validation->errors()];
        }
    
        $user = new User();
        $user->fill((array) $user);
        $user->email = $input['usernameOrEmail']; // Used for both email or username lookup
        $user->password = $input['password'];
    
        if ($user->login()) {
            $_SESSION['user_id'] = $user->id;
            return ['success' => true];
        }
    
        return ['success' => false, 'errors' => ['auth' => ['Invalid credentials.']]];
    }

    public function fetchUserById(int $id): ?User
    {
        $user = new User();
        $user->id = $id;
    
        $data = $user->fetchUserById(); // likely returns stdClass or array
    
        if (!$data) return null;
    
        $user->fill((array) $data); // fill the User instance with DB values
        return $user;
    }
    

}    
