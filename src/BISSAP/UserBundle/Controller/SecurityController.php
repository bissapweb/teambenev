<?php
/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BISSAP\UserBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
    $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');

        // if ($authChecker->isGranted('ROLE_BENEV')) {
     //     return new RedirectResponse($router->generate('bissap_benevoles_indexuser'), 307);
        // }     

        // if ($authChecker->isGranted('ROLE_ORGA')) {
     //     return new RedirectResponse($router->generate('bissap_benevoles_indexuser'), 307);
        // }

        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();
        if (class_exists('\Symfony\Component\Security\Core\Security')) {
            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $lastUsernameKey = Security::LAST_USERNAME;
        } else {
            // BC for SF < 2.6
            $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
            $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
        }
        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }
        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);
        if ($this->has('security.csrf.token_manager')) {
            $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
        } else {
            // BC for SF < 2.4
            $csrfToken = $this->has('form.csrf_provider')
                ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
                : null;
        }
        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    public function loginOrgaAction(Request $request)
    {
	$authChecker = $this->container->get('security.authorization_checker');
    	$router = $this->container->get('router');

    	// if ($authChecker->isGranted('ROLE_BENEV')) {
     //    	return new RedirectResponse($router->generate('bissap_benevoles_indexuser'), 307);
    	// }	 

    	// if ($authChecker->isGranted('ROLE_ORGA')) {
     //    	return new RedirectResponse($router->generate('bissap_benevoles_indexuser'), 307);
    	// }

        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();
        if (class_exists('\Symfony\Component\Security\Core\Security')) {
            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $lastUsernameKey = Security::LAST_USERNAME;
        } else {
            // BC for SF < 2.6
            $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
            $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
        }
        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }
        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);
        if ($this->has('security.csrf.token_manager')) {
            $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
        } else {
            // BC for SF < 2.4
            $csrfToken = $this->has('form.csrf_provider')
                ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
                : null;
        }
        return $this->renderLoginOrga(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }
    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
                if( $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') ){

                                return new RedirectResponse($this->container->get('router')->generate('bissap_coreBundle_index', array())); 
                }

        return $this->render('BISSAPUserBundle:Security:login.html.twig', $data);

    }

    protected function renderLoginOrga(array $data)
    {
                if( $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') ){

                                return new RedirectResponse($this->container->get('router')->generate('bissap_orgaBundle_index', array())); 
                }

        return $this->render('BISSAPUserBundle:Security:loginOrga.html.twig', $data);

    }
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }
    public function logoutAction()
    {
        return $this->redirect($this->generateUrl('bissap_coreBundle_index'));
        //throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}