<?php

namespace Album\Utility;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;

class AclService extends Acl{
	public function __construct(){
		$this->addRole(new GenericRole('fan'));
		$this->addRole(new GenericRole('admin'));
		$this->addResource(new GenericResource('Album\Controller\AlbumController::addAction'));
		$this->addResource(new GenericResource('Album\Controller\AlbumController::editAction'));
		$this->addResource(new GenericResource('Album\Controller\AlbumController::deleteAction'));
		$this->addResource(new GenericResource('Album\Controller\ImageController::deleteAction'));
		$this->allow('fan', 'Album\Controller\AlbumController::addAction');
		$this->allow('fan', 'Album\Controller\AlbumController::editAction');
		$this->deny('fan', 'Album\Controller\AlbumController::deleteAction');
		$this->allow('admin', 'Album\Controller\AlbumController::addAction');
		$this->allow('admin', 'Album\Controller\AlbumController::editAction');
		$this->allow('admin', 'Album\Controller\AlbumController::deleteAction');
		$this->allow('admin', 'Album\Controller\ImageController::deleteAction');
		$this->deny('fan', 'Album\Controller\ImageController::deleteAction');
	}
}
