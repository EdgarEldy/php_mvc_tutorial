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
    protected $profilModel;
    public function __construct()
    {
        $this->profilModel=$this->model('profil');
    }
    
    public function index()
    {
        if (!isLoggedIn()) {
            redirect('users/login')  ;
        }
        $profils=$this->profilModel->getprofiles();
        $data= [
            'profils' => $profils
        ];
        return $this->render('profils/index',$data);
    }
    
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            //Process form
            $data = [
                'nom_profil' => trim($_POST['nom_profil']),
                'nom_profil_err' => ''
            ];
            
            // Validate nom_profil
            if ( empty($data['nom_profil']) ) {
                $data['nom_profil_err'] = 'Veuillez entrer le profil !';
            } else {
                // Check nom_profil
                if ( $this->profilModel->getprofilByName($data['nom_profil']) ) {
                    $data['nom_profil_err'] = 'Ce profil existe deja !';
                }
            }
            
            //Make sure errors are empty
            if ( empty($data['nom_profil_err']) ) {
                
                if ( $this->profilModel->add($data) ) {
                    flash('Enregistrement r�ussi','Le profil a ete ajout� !');
                    redirect('profils/index');
                } else {
                    die ('Something wrong');
                }
            }
            else
            {
                // Load view with errors
                $this->render('profils/add',$data);
            }
            
        }
        
        else
        {
            $data = [
                'nom_profil' => '',
                'nom_profil_err' => ''
            ];
            $this->render('profils/add',$data);
        }
    }
    
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST' ) {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING) ;
            $data=[
                'id' => $id,
                'nom_profil'=>trim($_POST['nom_profil']),
                'nom_profil_err'=>''
            ];
            
            //Validation
            if (empty($data['nom_profil'])) {
                $data['nom_profil_err'] = 'Veuillez entrer le profil !'  ;
            }
            
            if (empty($data['nom_profil_err'])) {
                if ($this->profilModel->update($data)) {
                    flash('Mise a jour reussi', 'Le profil a ete mis a jour ')  ;
                    redirect('profils/index');
                }
                else die('Something went wrong !');
            }
            else $this->render('profils/edit',$data);
            
        }
        
        else
        {
            $profil=$this->profilModel->getprofilById($id);
            $data=[
                'id'=>$profil->id_profil,
                'nom_profil'=> $profil->nom_profil,
                'nom_profil_err'=>''
            ];
            $this->render('profils/edit',$data);
        }
    }
    
    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if( $this->profilModel->delete($id) ){
                flash('Suppression reussi', 'Post removed');
                redirect('profils/index');
            } else {
                die('Something went wrong');
            }
            
        } else {
            redirect('profils/index');
        }
    } //end function
}

