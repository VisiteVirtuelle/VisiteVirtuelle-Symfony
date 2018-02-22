<?php

namespace Votop\UserBundle\Entity;

use FOS\UserBundle\Model\User as FosUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends FosUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
    protected $id;
	
	public function __construct()
	{
		parent::__construct();
	}
 }
 
 ?>