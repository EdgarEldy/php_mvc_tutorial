<?php
namespace controllers;

/**
 *
 * @author EDGARELDY
 *        
 */
class customers
{

    /**
     */
    protected $proprietaireModel;
    public function __construct()
    {
        $this->proprietaireModel= $this->model('proprietaire');
    }
    
    public function index()
    {
        if (!isLoggedIn()) {
            redirect('users/login') ;
        }
        $proprietaires= $this->proprietaireModel->getProprietaires();
        $data=[
            'proprietaires' => $proprietaires
        ];
        $this->render('proprietaires/index',$data);
    }
    
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST=filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING)  ;
            //Process form
            $data = [
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'tel' => trim($_POST['tel']),
                'email' => trim($_POST['email']),
                'adresse' => trim($_POST['adresse']),
                'cni' => trim($_POST['cni']),
                'nom_err' => '',
                'prenom_err' => '',
                'tel_err' => '',
                'email_err' => '',
                'adresse_err' => '',
                'cni_err' => ''
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
            if ( empty($data['tel']) ) {
                $data['tel_err'] = 'Veuillez entrer votre numero de telephone !';
            }
            
            // Validate email
            if ( empty($data['email']) ) {
                $data['email_err'] = 'Veuillez entrer votre email !';
            }
            
            // Validate adresse
            if ( empty($data['adresse']) ) {
                $data['adresse_err'] = 'Veuillez entrer l\'adresse !';
            }
            
            // Validate Confirm Password
            if ( empty($data['cni']) ) {
                $data['cni_err'] = 'Veuillez confirmer la carte d\'identit� !';
            }
            
            //Make sure errors are empty
            if ( empty($data['nom_err']) && empty($data['prenom_err']) && empty($data['tel_err']) && empty($data['email_err'])
                && empty($data['adresse_err']) && empty($data['cni_err']) ) {
                    if ( $this->proprietaireModel->add($data) ) {
                        flash('register_success','You are now registered! You !');
                        redirect('proprietaires/index');
                    } else {
                        die ('Something wrong');
                    }
                }
                else
                {
                    // Load view with errors
                    $this->render('proprietaires/add',$data);
                }
                
        }
        
        else
        {
            $data = [
                'nom' => '',
                'prenom' => '',
                'tel' => '',
                'email' => '',
                'adresse' => '',
                'cni' => '',
                'nom_err' => '',
                'prenom_err' => '',
                'tel_err' => '',
                'email_err' => '',
                'adresse_err' => '',
                'cni_err' => ''
            ];
            $this->render('proprietaires/add',$data);
        }
    }
    
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD']== 'POST' ) {
            $_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING) ;
            $data=[
                'id' => $id,
                'nom' => trim($_POST['nom']),
                'prenom' => trim($_POST['prenom']),
                'tel' => trim($_POST['tel']),
                'email' => trim($_POST['email']),
                'adresse' => trim($_POST['adresse']),
                'cni' => trim($_POST['cni']),
                'nom_err' => '',
                'prenom_err' => '',
                'tel_err' => '',
                'email_err' => '',
                'adresse_err' => '',
                'cni_err' => ''
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
            if ( empty($data['tel']) ) {
                $data['tel_err'] = 'Veuillez entrer votre numero de telephone !';
            }
            
            // Validate email
            if ( empty($data['email']) ) {
                $data['email_err'] = 'Veuillez entrer votre email !';
            }
            
            // Validate adresse
            if ( empty($data['adresse']) ) {
                $data['adresse_err'] = 'Veuillez entrer l\'adresse !';
            }
            
            // Validate Confirm Password
            if ( empty($data['cni']) ) {
                $data['cni_err'] = 'Veuillez confirmer la carte d\'identit� !';
            }
            
            //Make sure errors are empty
            if ( empty($data['nom_err']) && empty($data['prenom_err']) && empty($data['tel_err']) && empty($data['email_err'])
                && empty($data['adresse_err']) && empty($data['cni_err']) ) {
                    if ( $this->proprietaireModel->update($data) ) {
                        flash('register_success','You are now registered! You !');
                        redirect('proprietaires/index');
                    } else {
                        die ('Something wrong');
                    }
                }
                else
                {
                    // Load view with errors
                    $this->render('proprietaires/edit',$data);
                }
                
                
        }
        
        else
        {
            $proprietaire=$this->proprietaireModel->getProprietaireById($id);
            $data = [
                'id'=>$proprietaire->id_prop,
                'nom' => $proprietaire->nom_prop,
                'prenom' => $proprietaire->prenom_prop,
                'tel' => $proprietaire->tel_prop,
                'email' => $proprietaire->email_prop,
                'adresse' => $proprietaire->adresse_prop,
                'cni' =>  $proprietaire->cni_prop,
                'nom_err' => '',
                'prenom_err' => '',
                'tel_err' => '',
                'email_err' => '',
                'adresse_err' => '',
                'cni_err' => ''
            ];
            $this->render('proprietaires/edit',$data);
        }
    }
    
    public function delete($id)
    {
        if($_SERVER['REQUEST_METHOD']=='POST') {
            if( $this->proprietaireModel->delete($id) ){
                flash('Suppression reussi', 'proprietaire removed');
                redirect('proprietaires/index');
            } else {
                die('Something went wrong');
            }
            
        } else {
            redirect('proprietaires/index');
        }
    }
}

