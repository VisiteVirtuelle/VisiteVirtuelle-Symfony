<?php

namespace Votop\UserBundle\Entity;

use FOS\UserBundle\Model\User as FosUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 

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
	
    /** 
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length( 
     *     min=3, 
     *     max=255, 
     *     minMessage="The name is too short.", 
     *     maxMessage="The name is too long.", 
     *     groups={"Registration", "Profile"} 
     * ) 
     */ 
    protected $name; 
    
	public function __construct()
	{
		parent::__construct();
	}
    
    /** 
     * {@inheritdoc} 
     */ 
    public function getName() 
    { 
        return $this->name; 
    } 
   
    /** 
     * {@inheritdoc} 
     */ 
    public function setName($name) 
    { 
        $this->name = $name; 
 
        return $this; 
    }
}
 
?>