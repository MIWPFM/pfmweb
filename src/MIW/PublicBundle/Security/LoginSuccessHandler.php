<?php
 
namespace MIW\PublicBundle\Security;
 
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext; 
use Symfony\Component\Routing\Router; 
 
/**
 * Custom authentication success handler
 */
class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface 
{
   protected $router;
 
    public function __construct(Router $router)
    {
        $this->router = $router;
    }
 
   /**
    * This is called when an interactive authentication attempt succeeds. This
    * is called by authentication listeners inheriting from AbstractAuthenticationListener.
    * @param Request        $request
    * @param TokenInterface $token
    * @return Response The response to return
    */
   function onAuthenticationSuccess(Request $request, TokenInterface $token)
   {
       
      if (!$token->getUser()->getCompletedProfile())
      {
         $uri = $this->router->generate('intranet_dashboard');
      }
      else
      {
          //TODO: Redirect to profile
         $uri = $this->router->generate('intranet_dashboard');
      }
 
      return new RedirectResponse($uri);
   }
}