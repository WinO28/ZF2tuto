<?php
 
namespace Album\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
 
use Album\Model\User;
 
class AuthController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;
     
    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }
         
        return $this->authservice;
    }
     
    public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                                  ->get('Album\Model\MyAuthStorage');
        }
         
        return $this->storage;
    }
     
    public function getForm()
    {
        if (! $this->form) {
            $user       = new User();
            $builder    = new AnnotationBuilder();
            $this->form = $builder->createForm($user);
        }
         
        return $this->form;
    }
     
    public function loginAction()
    {
        //if already login, redirect to success page 
        if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('success');
        }
                 
        $form       = $this->getForm();
         
        return array(
            'form'      => $form,
            'messages'  => $this->flashmessenger()->getMessages()
        );
    }
     
    public function authenticateAction()
    {
        $form       = $this->getForm();
        $redirect = 'auth';
         
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){
                //check authentication...
                $this->getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('username'))
                                       ->setCredential($request->getPost('password'));
                                        
                $result = $this->getAuthService()->authenticate();
                foreach($result->getMessages() as $message)
                {
                    //save message temporary into flashmessenger
                    $this->flashmessenger()->addErrorMessage($message);
                }
                 
                if ($result->isValid()) {
									$userrole= $this->getRole($request->getPost('username'));
									$userid= $this->getId($request->getPost('username'));									
									$redirect = 'album';

										$role=(array(								
										'id' => $userid,									
										'login' => $request->getPost('username'),										
										'role' => $userrole
										));

									//$this->getAuthService()->getStorage()->write($request->getPost('username'));

										$this->getAuthService()->getStorage()->write($role);										
									}			
								}


									foreach($form->getMessages('username') as $usermessage)									
									{
									//save message temporary into flashmessenger									
									$this->flashmessenger()->addErrorMessage($usermessage);									
									}
									
									foreach($form->getMessages('password') as $passmessage)
									{									
									//save message temporary into flashmessenger									
									$this->flashmessenger()->addErrorMessage($passmessage);									
									}
									
				}

			return $this->redirect()->toRoute($redirect);
}
     
    public function logoutAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
         
        $this->flashmessenger()->addMessage("Vous avez ete deconnecte");
        return $this->redirect()->toRoute('login');
    }
    
    public function getRole($name)
    {
    	$sql="SELECT role FROM `users` WHERE `user_name` ='".$name."'";

    	$sm = $this->getServiceLocator();
    	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    	$selectData = array();
    	foreach ($result as $res) {
    		$selectData[]=$res;
    	}
    	$roluser=$selectData[0]['role'];
    	echo $roluser;
    
    	return $roluser;
    }
    
    public function getId($name)
    {
    	$sql="SELECT id FROM `users` WHERE `user_name` ='".$name."'";

    	$sm = $this->getServiceLocator();
    	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    	$statement = $dbAdapter->query($sql);
    	$result    = $statement->execute();
    	$selectData = array();
    	foreach ($result as $res) {
    		$selectData[]=$res;
    	}
    	$iduser=$selectData[0]['id'];
    
    	return $iduser;
    }
    
}




















// namespace Album\Controller;

// use Zend\Mvc\Controller\AbstractActionController;
// use Album\Form\AuthForm;
// use Album\Form\AuthValidator;

// class AuthController extends AbstractActionController {
    
// 		protected $storage;	
//     public function indexAction() {
//         $form = new AuthForm();
//         $request = $this->getRequest();
    
//         if($request->isPost())
//         {
//             $formValidator = new AuthValidator();
//             $form->setInputFilter($formValidator->getInputFilter());
            
//             $form->setData($request->getPost());
//             $login = $request->getPost('login');
//             $pass = $request->getPost('pass');
             
//             if($form->isValid()){
//                 {
//                     $pass=md5($pass);
//                     //$form->setData($data);
                    
//                     $fichier = fopen('/home/lp14hc/AppZF/other/listeloginmdp.txt', 'r+'); // j'ouvre le fichier qui contient le nom d'utilisateur et le mot de passe.
//                     if ($fichier){
//                         $donneetrouvee=false;
//                         while (!feof($fichier)){
//                             $ligne = fgets($fichier); // je recupere l'user/password du fichier listeloginmdp.txt
//                             $delimite=explode(" ", $ligne);
//                             $user=trim($delimite[0]);
//                             $pswd=trim($delimite[1]);
                    
//                             if($login==$user and $pass==$pswd) // je test
//                             {
//                                 echo 'Bienvenue '.$login;
//                                 $donneetrouvee=true;
//                                 $this->getServiceLocator()->get('AuthService')->getStorage()->write($request->getPost('login'));
//                                 return $this->redirect()->toRoute('album');
//                             }
                    
//                             if($login==$user and $pass!=$pswd) // je test
//                             {
//                                 $this->flashMessenger()->addErrorMessage('Cet utilisateur existe deja ou votre mot de passe incorrect !');
//                                 return array('form' =>$form);
//                             }
//                         }
//                         if (!$donneetrouvee){
//                             fputs($fichier, "\n".$login.' '.$pass);
//                             $this->flashMessenger()->addSuccessMessage('Vous etes inscrit !');
//                             return array('form' =>$form);
//                         }
//                         fclose($fichier);
//                     }
//                 }
//             }
//             else
//             return array('form' =>$form);
//         } else {
//             return array('form' =>$form);
//         }
//     }
    
// public function getSessionStorage()
//  {
	
// 	if (!$this->storage) {
// 		$this->storage = $this->getServiceLocator()->get('Storage\Session');
// 	}
// 	return $this->storage;
	
//  }
 
// public function decoAction()

// {
// 	$this->getSessionStorage()->forgetMe();	
//  $this->getServiceLocator()->get('AuthService')->clearIdentity();
//  return $this->redirect()->toRoute('auth');
// }
    
// }

