<?php
namespace Album\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class AuthForm  extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('');

		$this->setAttribute('method', 'post');

		$this->add(array(
				'name' => 'login',
				'type' => 'Zend\Form\Element\Email',
				'attributes' => array(
						'placeholder' => 'Entrez votre adresse mail',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'login',
				),
		));

		$this->add(array(
				'name' => 'pass',
				'type' => 'Zend\Form\Element\Password',
				'attributes' => array(
						'placeholder' => 'Entrez votre mot de passe',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'pass',
				),
		));
	}
}