<?php

namespace MIW\RestBundle\Security\Authentication\Provider;

use MIW\RestBundle\Security\Authentication\Token\WSSEUserToken;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class WSSEProvider implements AuthenticationProviderInterface
{
    private $userProvider;
    private $cacheDir;

    public function __construct(UserProviderInterface $userProvider, $cacheDir)
    {
        $this->userProvider = $userProvider;
        $this->cacheDir     = $cacheDir;
    }

    public function authenticate(TokenInterface $token)
    {
        $user = $this->userProvider->loadUserByUsername($token->getUsername());

        if ($user && $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getPassword())) {
            $authenticatedToken = new WSSEUserToken($user->getRoles());
            $authenticatedToken->setUser($user);
            
            
            return $authenticatedToken;
        }
        
        throw new AuthenticationException('WSSE authentication failed.');
    }

    protected function getSecret(UserInterface $user)
    {
        return $user->getPassword();
    }

    protected function getSalt(UserInterface $user)
    {
        return $user->getSalt();
    }

    protected function validateDigest($digest, $nonce, $created, $secret)
    {
        // Check created time is not in the future
    /*    if (strtotime($created) > time()) {
            return false;
        }
        
        // Expire timestamp after 5 minutes
        if (time() - strtotime($created) > 300) {
            return false;
        }*/

        // Validate that the nonce is *not* used in the last 5 minutes
        // if it has, this could be a replay attack
        if (file_exists($this->cacheDir.'/'.$nonce) && file_get_contents($this->cacheDir.'/'.$nonce) + 300 > time()) {
            throw new NonceExpiredException('Previously used nonce detected');
        }
        // If cache directory does not exist we create it
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
        file_put_contents($this->cacheDir.'/'.$nonce, time());

        // Validate Secret
        $expected = base64_encode(sha1(base64_decode($nonce).$created.$secret, true));
       
        return $digest === $expected;
    }

   

    public function getUserProvider()
    {
        return $this->userProvider;
    }
    
    public function supports(TokenInterface $token)
    {
        return $token instanceof WSSEUserToken;
    }

}