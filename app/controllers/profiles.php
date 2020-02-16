<?php
use php_mvc_tutorial\app\libraries\controller\controller;

/**
 *
 * @author EDGARELDY
 *        
 */
class profiles extends controller
{

    /**
     */
    protected $profileModel;
    public function __construct()
    {
        $this->profileModel=$this->model('profile');
    }
    
    public function index()
    {
        if (!isLoggedIn()) {
            redirect('users/login')  ;
        }
        $profiles=$this->profileModel->getprofiles();
        $data= [
            'profiles' => $profiles
        ];
        return $this->render('profiles/index',$data);
    }
    
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            //Process form
            $data = [
                'profile_name' => trim($_POST['profile_name']),
                'profile_name_err' => ''
            ];
            
            // Validate profile name
            if ( empty($data['profile_name']) ) {
                $data['profile_name_err'] = 'Please enter profile name !';
            } else {
                // Check profile name
                if ( $this->profileModel->getprofilByName($data['profile_name']) ) {
                    $data['profile_name_err'] = 'Profile name already exists !';
                }
            }
            
            //Make sure errors are empty
            if ( empty($data['profile_name_err']) ) {
                
                if ( $this->profileModel->add($data) ) {
                    //flash('Enregistrement r�ussi','Le profil a ete ajout� !');
                    redirect('profiles/index');
                } else {
                    die ('Something wrong');
                }
            }
            else
            {
                // Load view with errors
                $this->render('profiles/add',$data);
            }
            
        }
        
        else
        {
            $data = [
                'profile_name' => '',
                'profile_name_err' => ''
            ];
            $this->render('profiles/add',$data);
        }
    }
    
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST' ) {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING) ;
            $data=[
                'id' => $id,
                'profile_name'=>trim($_POST['profile_name']),
                'profile_name_err'=>''
            ];
            
            //Validation
            if (empty($data['profile_name'])) {
                $data['profile_name_err'] = 'Please enter profile name !'  ;
            }
            
            if (empty($data['profile_name_err'])) {
                if ($this->profileModel->update($data)) {
                    flash('Mise a jour reussi', 'Le profil a ete mis a jour ')  ;
                    redirect('profiles/index');
                }
                else die('Something went wrong !');
            }
            else $this->render('profiles/edit',$data);           
        }
        
        else
        {
            $profile=$this->profileModel->getprofileById($id);
            $data=[
                'id'=>$profile->profile_id,
                'profile_name'=> $profile->profile_name,
                'profile_name_err'=>''
            ];
            $this->render('profiles/edit',$data);
        }
    }
    
    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if( $this->profileModel->delete($id) ){
                flash('Suppression reussi', 'Post removed');
                redirect('profiles/index');
            } else {
                die('Something went wrong');
            }
            
        } else {
            redirect('profiles/index');
        }
    } //end function
}

