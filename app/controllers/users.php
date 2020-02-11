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
    protected $profilModel,$userModel;
    public function __construct()
    {
        $this->profilModel=$this->model('profil');
        $this->userModel=$this->model('utilisateur');
    }
    
    public function index()
    {
        if (!isLoggedIn()) {
            redirect('users/login') ;
        }
        $users= $this->userModel->getUsers();
        $data = [
            'users' =>$users
        ];
        return $this->render('users/index',$data);
    }
    
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            $profil =$this->profilModel->getProfiles();
            //var_dump($profil);
            $date= date('Y-m-d');
            //Process form
            $data = [
                'profil' => $profil,
                'profil_id' => trim($_POST['profil_id']),
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'pwd' => trim($_POST['pwd']),
                'confirm_pwd' => trim($_POST['confirm_pwd']),
                'date_registered' => $date,
                'nom_err' => '',
                'prenom_err' => '',
                'username_err' => '',
                'email_err' => '',
                'pwd_err' => '',
                'confirm_pwd_err' => ''
            ];
            // On valide le nom
            if ( empty($data['nom']) ) {
                $data['nom_err'] = 'Veuillez entrer votre nom !';
            }
            
            // On valide le prenom
            if ( empty($data['prenom']) ) {
                $data['prenom_err'] = 'Veuillez entrer votre prenom !';
            }
            
            // On valide le nom d'utilisateur
            if ( empty($data['username']) ) {
                $data['username_err'] = 'Veuillez entrer votre nom d\'utilisateur !';
            }
            
            // Validate email
            if ( empty($data['email']) ) {
                $data['email_err'] = 'Veuillez entrer votre email !';
            } else {
                // Check email
                if ( $this->userModel->getUserByEmail($data['email']) ) {
                    $data['email_err'] = 'Votre email est deja attribu� !';
                }
            }
            
            // Validate Password
            if ( empty($data['pwd']) ) {
                $data['pwd_err'] = 'Veuillez entrer votre mot de passe !';
            } elseif ( strlen($data['pwd']) < 6 ) {
                $data['pwd_err'] = 'Le mot de passe doit avoir au moins 6 caracteres !';
            }
            
            // Validate Confirm Password
            if ( empty($data['confirm_pwd']) ) {
                $data['confirm_pwd_err'] = 'Veuillez confirmer votre mot de passe !';
            } else if ( $data['pwd'] != $data['confirm_pwd'] ) {
                $data['confirm_pwd_err'] = 'Le mot de passe ne correspond pas !';
            }
            
            //Make sure errors are empty
            if ( empty($data['nom_err']) && empty($data['prenom_err']) && empty($data['username_err']) && empty($data['email_err'])
                && empty($data['pwd_err']) && empty($data['confirm_pwd_err']) ) {
                    // Hash Password
                    $data['pwd'] = password_hash($data['pwd'], PASSWORD_DEFAULT);
                    
                    if ( $this->userModel->register($data) ) {
                        flash('register_success','You are now registered! You !');
                        $this->login();
                        //redirect('posts/login');
                    } else {
                        die ('Something wrong');
                    }
                }
                else
                {
                    // Load view with errors
                    $this->render('users/add',$data);
                }
                
        }
        
        else
        {
            $profil =$this->profilModel->getProfiles();
            $data = [
                'profil' => $profil,
                'profil_id' => '',
                'nom' => '',
                'prenom' => '',
                'username' => '',
                'email' => '',
                'pwd' => '',
                'confirm_pwd' => '',
                'nom_err' => '',
                'prenom_err' => '',
                'username_err' => '',
                'email_err' => '',
                'pwd_err' => '',
                'confirm_pwd_err' => ''
            ];
            $this->render('users/add',$data);
        }
    }
    
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] =='POST') {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            
            //On procede a la recuperation des donnees du formulaire
            
            $data= [
                'email' => trim($_POST['email']),
                'pwd' => trim($_POST['pwd']),
                'email_err' =>'',
                'pwd_err' => ''
            ];
            
            //Validation de l'email
            if (empty($data['email'])) {
                $data['email_err'] = 'Veuillez saisir votre email !' ;
            }
            elseif (!$this->userModel->getUserByEmail($data['email']))
            {
                $data['email_err'] = 'Utilisateur non trouv� !';
            }
            
            // Validation du mot de passe
            if (empty($data['pwd'])) {
                $data['pwd_err'] = 'Veuillez entrer votre mot de passe !'  ;
            }
            
            // Make sure datas are empty
            if (empty($data['email_err']) && empty($data['pwd_err'])) {
                $userConnected= $this->userModel->login($data['email'], $data['pwd'])  ;
                if ($userConnected) {
                    $this->createUserSession($userConnected)  ;
                }
                
                else
                {
                    $data=[
                        'email' => '',
                        'pwd' => '',
                        'email_err' => '' ,
                        'pwd_err' => 'Votre mot de passe ne correspond pas !'
                    ];
                    
                    $this->view('users/login', $data);
                }
            }
            
            else
            {
                $this->view('users/login', $data);
            }
            
        }
        
        else
        {
            $data= [
                'email' => '',
                'pwd' => '',
                'email_err' =>'',
                'pwd_err' => ''
            ];
            
            // On appelle la vue
            $this->view('users/login', $data);
        }
    }
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST' ) {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING) ;
            $user=$this->userModel->getUserById($id);
            $data=[
                'id' => $id,
                'nom_profil'=>$user->nom_profil,
                'profil_id'=>trim($_POST['profil_id']),
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'tel' => trim($_POST['tel']),
                'adresse' => trim($_POST['adresse']),
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'pwd' => trim($_POST['pwd']),
                'confirm_pwd' => trim($_POST['confirm_pwd']),
                'nom_err' => '',
                'prenom_err' => '',
                'tel_err' => '',
                'adresse_err' => '',
                'username_err' => '',
                'email_err' => '',
                'pwd_err' => '',
                'confirm_pwd_err' => ''
            ];
            
            // On valide le nom
            if ( empty($data['nom']) ) {
                $data['nom_err'] = 'Veuillez entrer votre nom !';
            }
            
            // On valide le prenom
            if ( empty($data['prenom']) ) {
                $data['prenom_err'] = 'Veuillez entrer votre prenom !';
            }
            
            // On valide le numero de telephone
            if ( empty($data['tel']) ) {
                $data['tel_err'] = 'Veuillez entrer votre numero de telephone !';
            }
            
            // On valide l'adresse
            if ( empty($data['adresse']) ) {
                $data['adresse_err'] = 'Veuillez entrer votre adresse !';
            }
            
            // On valide le nom d'utilisateur
            if ( empty($data['username']) ) {
                $data['username_err'] = 'Veuillez entrer votre nom d\'utilisateur !';
            }
            
            // Validate email
            if ( empty($data['email']) ) {
                $data['email_err'] = 'Veuillez entrer votre email !';
            }
            // else {
            //     // Check email
            //     if ( $this->userModel->getUserByEmail($data['email']) ) {
            //         $data['email_err'] = 'Votre email est deja attribu� !';
            //     }
            // }
            
            // Validate Password
            if ( empty($data['pwd']) ) {
                $data['pwd_err'] = 'Veuillez entrer votre mot de passe !';
            } elseif ( strlen($data['pwd']) < 6 ) {
                $data['pwd_err'] = 'Le mot de passe doit avoir au moins 6 caracteres !';
            }
            
            // Validate Confirm Password
            if ( empty($data['confirm_pwd']) ) {
                $data['confirm_pwd_err'] = 'Veuillez confirmer votre mot de passe !';
            } else if ( $data['pwd'] != $data['confirm_pwd'] ) {
                $data['confirm_pwd_err'] = 'Le mot de passe ne correspond pas !';
            }
            
            //Make sure errors are empty
            if ( empty($data['nom_err']) && empty($data['prenom_err']) && empty($data['tel_err']) && empty($data['adresse_err'])
                && empty($data['username_err']) && empty($data['email_err']) && empty($data['pwd_err']) && empty($data['confirm_pwd_err']) ) {
                    // Hash Password
                    $data['pwd'] = password_hash($data['pwd'], PASSWORD_DEFAULT);
                    
                    if ( $this->userModel->update($data) ) {
                        flash('register_success','You are now registered! You !');
                        redirect('users/profile');
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
            $user=$this->userModel->getUserById($id);
            $data = [
                'id'=>$user->id_user,
                'profil_id' => $user->id_profil,
                'nom_profil' => $user->nom_profil,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'tel' => $user->tel,
                'adresse' => $user->adresse,
                'username' => $user->username,
                'email' => $user->email,
                'pwd' => '',
                'confirm_pwd' => '',
                'nom_err' => '',
                'prenom_err' => '',
                'tel_err' => '',
                'adresse_err' => '',
                'username_err' => '',
                'email_err' => '',
                'pwd_err' => '',
                'confirm_pwd_err' => ''
            ];
            $this->render('users/edit',$data);
        }
    }
    
    public function profile()
    {
        if (!isLoggedIn()) {
            redirect('users/login') ;
        }
        $users= $this->userModel->getUserByProfile($_SESSION['user_id']);
        $data = [
            'users' =>$users
        ];
        return $this->render('users/profile',$data);
    }
    
    public function createUserSession($user)
    {
        $_SESSION['user_id']= $user->id_user;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['username'] = $user->username;
        redirect('home');
    }
}

