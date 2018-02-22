<?php

namespace Votop\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VotopUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
