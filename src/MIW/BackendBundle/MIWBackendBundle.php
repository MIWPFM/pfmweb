<?php

namespace MIW\BackendBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MIWBackendBundle extends Bundle
{
    
    public function getParent()
    {
        return 'SonataAdminBundle';
    }
}
