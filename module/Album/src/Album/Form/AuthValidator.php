<?php
namespace Album\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AuthValidator implements InputFilterAwareInterface
{
	protected $inputFilter;

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter)
		{
			$inputFilter = new InputFilter();
			$factory = new InputFactory();


			$inputFilter->add($factory->createInput([
					'name' => 'login',
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array (
									'name' => 'EmailAddress',
									'options' => array(
											'messages' => array(
													'emailAddressInvalidFormat' => 'Adresse mail invalide',
											)
									),
							),
							array (
									'name' => 'NotEmpty',
									'options' => array(
											'messages' => array(
													'isEmpty' => 'Adresse mail requise',
											)
									),
							),
					),
			]));

			$inputFilter->add($factory->createInput([
					'name' => 'pass',
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array (
									'name' => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min' => '8',
									),
							),
					),
			]));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}