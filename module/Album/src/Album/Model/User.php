<?php
namespace Album\Model;

use Zend\Form\Annotation;

/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("Users")
 */
class User
{
	/** 
	 * @Annotation\Type("Zend\Form\Element\Text")
	 * @Annotation\Required({"required":"true" })
	 * @Annotation\Filter({"name":"StripTags"})
	 * @Annotation\Options({"label":"E-mail: "})
	 */
	public $username;
	 
	/** 
	 * @Annotation\Type("Zend\Form\Element\Password")
	 * @Annotation\Required({"required":"true" })
	 * @Annotation\Filter({"name":"StripTags"})
	 * @Annotation\Options({"label":"Mot de passe: "})
	 */
	public $password;
	 
	/** 
	 * @Annotation\Type("Zend\Form\Element\Checkbox")
	 * @Annotation\Options({"label":"Se souvenir ?:"})
	 */
	public $rememberme;
	 
	/** 
	 * @Annotation\Type("Zend\Form\Element\Submit")
	 * @Annotation\Attributes({"value":"Submit"})
	 */
	public $submit;
	
	public function exchangeArray($data)
	
	{
	
		$this->id = (!empty($data['id'])) ? $data['id'] : null;
	
		$this->username = (!empty($data['username'])) ? $data['username'] : null;
	
		$this->password = (!empty($data['password'])) ? $data['password'] : null;
	
		$this->role = (!empty($data['role'])) ? $data['role'] : 'fan';
	
	}
}

