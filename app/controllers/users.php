<?php
use php_mvc_tutorial\app\libraries\controller\controller;

/**
 *
 * @author EDGARELDY
 *        
 */
class users extends controller
{

    /**
     */
    protected $profileModel,$userModel;
    public function __construct()
    {
      $this->userModel = $this->model('user');
      $this->profileModel = $this->model('profile');
    }
    
    public function index()
    {
        // if(!isLoggedIn() ){
        //     redirect('users/login');
        // }
        $users = $this->userModel->getUsers();
        $data = [
            'users' => $users
        ];
        return $this->render('users/index', $data);
    }

     public function profile()
    {
//         if (!isLoggedIn()) {
//             redirect('users/login') ;
//         }
        $users= $this->userModel->getUserByProfile($_SESSION['user_id']);
        $data = [
            'users' =>$users
        ];
        return $this->render('users/profile',$data);
    }

    public function add()
    {
        //Check for POST
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            // Sanitize POST Data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $profile = $this->profileModel->getprofiles();

            // Process form
            $data = [
            'profiles' => $profile,
            'fk_profile_id' => trim($_POST['fk_profile_id']),
            'username' => trim($_POST['username']),
            'pwd' => trim($_POST['pwd']),
            'confirm_pwd' => trim($_POST['confirm_pwd']),
            'fk_profile_id_err' => '',
            'username_err' => '',
            'pwd_err' => '',
            'confirm_pwd_err' => ''
            ];

            //Validate profile
            if ( empty($data['fk_profile_id']) ) {
                $data['fk_profile_id_err'] = 'Please select profile name !';
            }

            // Validate username
            if ( empty($data['username']) ) {
                $data['username_err'] = 'Please inform your username';
            } else {
                // Check username
                if ( $this->userModel->getUserByUsername($data['username']) ) {
                    $data['username_err'] = 'username is already in use. Choose another one!';
                }
            }

             // Validate pwd
             if ( empty($data['pwd']) ) {
                $data['pwd_err'] = 'Please inform your pwd';
             } elseif ( strlen($data['pwd']) < 6 ) {
                $data['pwd_err'] = 'pwd must be at least 6 characters';
             }

             // Validate Confirm pwd
             if ( empty($data['confirm_pwd']) ) {
                 $data['confirm_pwd_err'] = 'Please inform your pwd';
             } else if ( $data['pwd'] != $data['confirm_pwd'] ) {
                 $data['confirm_pwd_err'] = 'pwd does not match!';
             }

             //Make sure errors are empty
             if ( empty($data['fk_profile_id_err']) && empty($data['username_err']) && empty($data['pwd_err']) && empty($data['confirm_pwd_err']) ) {
                 // Hash pwd
                 $data['pwd'] = password_hash($data['pwd'], PASSWORD_DEFAULT);

                 if ( $this->userModel->add($data) ) {
                     flash('register_success','You are now registered! You !');
                     redirect('home');
                 } else {
                     die ('Something wrong');
                 }
             } else{
                 // Load view with errors
                 $this->render('users/add',$data);
             }
        } else {
            // Init data
            $profile =$this->profileModel->getProfiles();
            $data = [
                'profiles' => $profile,
                'fk_profile_id_err' => '',
                'username' => '',
                'pwd' => '',
                'confirm_pwd' => '',
                'username_err' => '',
                'pwd_err' => '',
                'confirm_pwd_err' => ''
            ];

            // Load view
            $this->render('users/add', $data);
        }
    }

    public function edit($id)
    {
        //Check for POST
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            // Sanitize POST Data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $profile = $this->profileModel->getprofiles();

            // Process form
            $data = [
            'profiles' => $profile,
            'fk_profile_id' => trim($_POST['fk_profile_id']),
            'username' => trim($_POST['username']),
            'pwd' => trim($_POST['pwd']),
            'confirm_pwd' => trim($_POST['confirm_pwd']),
            'fk_profile_id_err' => '',
            'username_err' => '',
            'pwd_err' => '',
            'confirm_pwd_err' => ''
            ];

            //Validate profile
            if ( empty($data['fk_profile_id']) ) {
                $data['fk_profile_id_err'] = 'Please select profile name !';
            }

            // Validate username
            if ( empty($data['username']) ) {
                $data['username_err'] = 'Please inform your username';
            } else {
                // Check username
                if ( $this->userModel->getUserByUsername($data['username']) ) {
                    $data['username_err'] = 'username is already in use. Choose another one!';
                }
            }

             // Validate pwd
             if ( empty($data['pwd']) ) {
                $data['pwd_err'] = 'Please inform your pwd';
             } elseif ( strlen($data['pwd']) < 6 ) {
                $data['pwd_err'] = 'pwd must be at least 6 characters';
             }

             // Validate Confirm pwd
             if ( empty($data['confirm_pwd']) ) {
                 $data['confirm_pwd_err'] = 'Please inform your pwd';
             } else if ( $data['pwd'] != $data['confirm_pwd'] ) {
                 $data['confirm_pwd_err'] = 'pwd does not match!';
             }

             //Make sure errors are empty
             if ( empty($data['fk_profile_id_err']) && empty($data['username_err']) && empty($data['pwd_err']) && empty($data['confirm_pwd_err']) ) {
                    // Hash Password
                    $data['pwd'] = password_hash($data['pwd'], PASSWORD_DEFAULT);
                    
                    if ( $this->userModel->update($data) ) {
                        flash('register_success','You are now registered! You !');
                        //redirect('users/index');
                        $this->render('users/edit',$data);
                    } else {
                        die ('Something wrong');
                    }
                }
                else
                {
                    // Load view with errors
                    $this->render('users/edit',$data);
                }
                
                
        }
        
        else
        {
            $profile =$this->profileModel->getProfiles();
            $user=$this->userModel->getUserById($id);
            $data = [
                'id'=>$user->user_id,
                'profiles' => $profile,
                'fk_profile_id' => $user->fk_profile_id,
                'username' => $user->username,
                'pwd' => '',
                'confirm_pwd' => '',
                'fk_profile_id_err' => '',
                'name_err' => '',
                'username_err' => '',
                'pwd_err' => '',
                'confirm_pwd_err' => ''
            ];
            $this->render('users/edit',$data);
        }
    }

    public function login()
    {
        //Check for POST
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            // Process form
            // Sanitize POST Data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Process form
            $data = [
                'username' => trim($_POST['username']),
                'pwd' => trim($_POST['pwd']),
                'username_err' => '',
                'pwd_err' => '',
            ];

            // Validate username
            if ( empty($data['username']) ) {
                $data['username_err'] = 'Please inform your username';
            } else if (! $this->userModel->getUserByUsername($data['username']) ) {
                // User not found
                $data['username_err'] = 'No user found!';
            }

            // Validate pwd
            if ( empty($data['pwd']) ) {
                $data['pwd_err'] = 'Please inform your pwd';
            }

            //Make sure are empty
            if ( empty($data['username_err']) && empty($data['pwd_err']) ) {
                // Validated
                // Check and set logged in user
                $userAuthenticated = $this->userModel->login($data['username'], $data['pwd']);
                if ( $userAuthenticated) {
                    // Create session
                    $this->createUserSession($userAuthenticated);
                } else {
                    $data = [
                        'username' => trim($_POST['username']),
                        'pwd' => '',
                        'username_err' => 'username or pwd are incorrect',
                        'pwd_err' => 'username or pwd are incorrect',
                    ];
                    $this->view('users/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('users/login',$data);
            }
        } else {
            // Init data
            $data = [
                'username' => '',
                'pwd' => '',
                'username_err' => '',
                'pwd_err' => '',
            ];
            // Load view
            $this->view('users/login', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_mail']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        redirect('home');
    }

    public function isLoggedIn()
    {
        if ( isset($_SESSION['user_id']) && isset($_SESSION['user_name']) && isset($_SESSION['user_username'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changepwd()
    {
        if(!isLoggedIn() ){
            redirect('users/login');
        }
        
        //Check for POST
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            // Sanitize POST Data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
            // Process form
            $data = [
                'username' => $_SESSION['user_username'],
                'pwd_old' => trim($_POST['pwd_old']),
                'pwd' => trim($_POST['pwd']),
                'confirm_pwd' => trim($_POST['confirm_pwd']),
                'pwd_old_err' => '',
                'pwd_err' => '',
                'confirm_pwd_err' => ''
            ];

            // Validate pwd Old
            if ( empty($data['pwd_old']) ) {
                $data['pwd_old_err'] = 'Please inform your old pwd';
            } elseif ( strlen($data['pwd_old']) < 6 ) {
                $data['pwd_old_err'] = 'pwd old must be at least 6 characters';
            } else if (! $this->userModel->checkpwd($data['username'], $data['pwd_old']) ) {
                $data['pwd_old_err'] = 'Your old pwd is wrong!';
            }
            
                // Validate pwd
            if ( empty($data['pwd']) ) {
                $data['pwd_err'] = 'Please inform your pwd';
            } elseif ( strlen($data['pwd']) < 6 ) {
                $data['pwd_err'] = 'pwd must be at least 6 characters';
            }
        
            // Validate Confirm pwd
            if ( empty($data['confirm_pwd']) ) {
                $data['confirm_pwd_err'] = 'Please confirm your pwd';
            } else if ( $data['pwd'] != $data['confirm_pwd'] ) {
                $data['confirm_pwd_err'] = 'pwd does not match!';
            }
        
            //Make sure errors are empty
            if ( empty($data['pwd_old_err']) && empty($data['pwd_err']) && empty($data['confirm_pwd_err']) ) {
                // Hash pwd
                $data['pwd'] = pwd_hash($data['pwd'], pwd_DEFAULT);
                
                if ( $this->userModel->updatepwd($data) ) {
                    flash('register_success','pwd updated!');
                    redirect('posts');
                } else {
                    die ('Something wrong');
                }
            } else{
                // Load view with errors
                $this->render('users/changepwd',$data);
            }
        } else {
            // Init data
            $data = [
                'username' => $_SESSION['user_username'],
                'pwd_old' => '',
                'pwd' => '',
                'confirm_pwd' => '',
                'pwd_old_err' => '',
                'pwd_err' => '',
                'confirm_pwd_err' => ''
            ];
        
            // Load view
            $this->render('users/changepwd', $data);
        }
    }

    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            // Get existing post from model
            $user = $this->userModel->getUserById($id);

            //Check if the user is logged
            if( $user->id == $_SESSION['user_id'] ){
                flash('user_message', 'You cannot delete your own user!');
                redirect('users');
            }
            
            //Check if the user has posts
            $row = $this->postModel->getPostByUserId($id);
            if ($row->total > 0 ) {
                flash('user_message', 'You cannot delete a user with published posts!');
                redirect('users');
            }
            
            if( $this->userModel->deleteUser($id) ){
                flash('user_message', 'The user was removed with success!');
                redirect('users');
            } else {
                flash('user_message', 'An erro ocurred when delete user');
                redirect('users');
            }
        
        } else {
            redirect('users');
        }
    } //end function
}

