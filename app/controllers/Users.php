<?php

    class Users extends Controller
    {
        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        public function register()
        {
            //Check for Post
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form

                // Sanitaze POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_error' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                //Validate email
                if (empty($data['email'])) {
                    $data['email_err'] = 'Please enter email';
                } else {
                    // Check email
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_err'] = 'Email is already taken';
                    }
                }

                //Validate name
                if (empty($data['name'])) {
                    $data['name_err'] = 'Please enter name';
                }

                //Validate password
                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter password';
                } elseif (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be at least 6 characters';
                }

                //Validate Confirm Password
                if (empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please confirm password';
                } else {
                    if ($data['password'] != $data['confirm_password']) {
                        $data['confirm_password_err'] = 'Passwords do not match';
                    }
                }

                // Make sure errors are empty
                if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) &&
                    empty($data['confirm_password_err'])) {
                    // Validated

                    // HAsh Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    //Register User
                    if($this->userModel->register($data)){
                        flash('register_success', 'You are registered and can log in');
                        redirect('users/login');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load view with errors
                    $this->view('users/register', $data);
                }

            } else {
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_error' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Load view
                $this->view('users/register', $data);

            }
        }

        public function login()
        {
            //Check fro Post
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form
                // Sanitaze POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];

                //Validate email
                if (empty($data['email'])) {
                    $data['email_err'] = 'Please enter email';
                }

                //Validate password
                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter password';
                }

                // Make sure errors are empty
                if (empty($data['email_err']) && empty($data['password_err'])) {
                    die('1111111');
                } else {
                    // Load view with errors
                    $this->view('users/login', $data);
                }

            } else {

                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => ''
                ];

                // Load view
                $this->view('users/login', $data);

            }
        }
    }