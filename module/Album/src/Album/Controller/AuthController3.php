<?php
namespace Album\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Mime\Message;

class AuthController extends AbstractActionController {
	
	public function indexAction() {
		$form = $this->createForm();
		
		$request = $this->getRequest();
		if ($request->isPost()){
			$login = $request->getPost('login');
			$pass = $request->getPost('pass');
			$pass = md5($pass);
			//$form->setData($data);
			
			if ($request->isPost()) {
				$fichier = fopen('/home/lp14hc/AppZF/other/listeloginmdp.txt', 'r+'); // j'ouvre le fichier qui contient le nom d'utilisateur et le mot de passe.
				if ($fichier) 
				{
					$donneetrouvee=false;
					while (!feof($fichier))
					{
						
						$ligne = fgets($fichier); // je recupere l'user/password du fichier listeloginmdp.txt
						$delimite=explode(" ", $ligne);
						$user=trim($delimite[0]);
						$pswd=trim($delimite[1]);
						
						if($login==$user and $pass!=$pswd) // je test
						{
							$this->flashMessenger()->addErrorMessage('Utilisateur deja connu ou mauvais mot de passe');
							return $this->redirect()->toRoute('auth');
						}
						
						if($login==$user and $pass==$pswd) // je test
						{
							echo 'Bienvenue '.$login;// header( 'Location: user.html' ); // redirection
						$donneetrouvee=true;
						return $this->redirect()->toRoute('album');
						}
						
					} 
					if (!$donneetrouvee)
						{
							fputs($fichier, "\n".$login.' '.$pass);
							$this->flashMessenger()->addSuccessMessage('Vous etes inscrit !');
							return $this->redirect()->toRoute('album');						
						}					
					fclose($fichier);
				}
				
				// code correspondant à l'authentification
				// ...
// 				if (strcmp($form->get('login')->getValue(), 'go_hu@hotmail.fr')== 0){
// 					return $this->redirect()->toRoute('album');
// 				}else { // mauvais log/pass
// 					$this->flashMessenger()->addErrorMessage('Erreur d\'identification');
// 					return array('formAuth' =>$form);
// 				}
			} else { // mauvaise saisie
				return array('formAuth' =>$form);
			}
			
		}else // affichage du formulaire
		return array('formAuth' =>$form);
	}
	
	/**
	 * Construction en mode programmmatique
	 * @return \Album\Controller\Form
	 */
	protected function createForm()
	{
		$login = new Element('login');
		$login->setLabel('Votre identifiant : ');
		$login->setAttributes(array(
		'type'=> 'email',
		'placeholder'=> 'votre login'
			)	
		);
		
		$pass = new Element('pass');
		$pass->setLabel('Votre mot de passe : ');
		$pass->setAttributes(array(
				'type'=> 'password',
				'placeholder'=> 'votre mot de passe'
				
		)
				
		);
		
		$form = new Form('identification');
		$form->add($login);
		$form->add($pass);
		
// 		$inputLogin= new Input('login');
// 		$inputLogin->setRequired(true);
// 		$inputLogin->getValidatorChain()->attachByName('alpha');
// 		$inputLogin->getFilterChain()->attachByName('alpha');
		$inputFilter = new InputFilter();
		$inputFilter->add(array(
				'name'=>'login',
				'required'=>true,
				'validators'=>array(
						array('name'=>'emailaddress')
				),
// 				'filters'=>array(
// 						array ('name'=>'digits')
// 				),
		 )
	);
		
		$form->setInputFilter($inputFilter);
		return $form;
	}
}


