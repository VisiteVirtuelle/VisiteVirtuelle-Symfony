<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent Claveau <vinc.claveau@gmail.com>
 *
 */

namespace App\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class VisitManager
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    private $class;

    /**
    * Constructor.
    *
    * @param ObjectManager            $om
    * @param string                   $class
    */
   public function __construct(ObjectManager $om, $class)
   {
       $this->objectManager = $om;
       $this->class = $class;
   }

   /**
    * Returns a collection with all visit instances.
    *
    * @return \Traversable
    */
    public function findVisits()
    {
        return $this->getRepository()->findAll();
    }

   /**
    * @return ObjectRepository
    */
   protected function getRepository()
   {
       return $this->objectManager->getRepository($this->getClass());
   }
}
