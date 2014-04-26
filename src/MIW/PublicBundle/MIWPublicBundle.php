<?php

namespace MIW\PublicBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MIWPublicBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
