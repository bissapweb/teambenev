<?php
 
namespace BISSAP\UserBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use FOS\UserBundle\Event\FilterUserResponseEvent; 
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
 
class RegistrationConfirmListener implements EventSubscriberInterface
{
    private $router;

    /** @var \Symfony\Component\Security\Core\SecurityContext */
    private $securityContext;

    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /**
     * Constructor
     *
     * @param SecurityContext $securityContext
     * @param Doctrine        $doctrine
     */
    public function __construct(UrlGeneratorInterface $router, SecurityContext $securityContext, Doctrine $doctrine)
    {
        $this->router = $router;

        $this->securityContext = $securityContext;
        $this->em = $doctrine->getEntityManager();
    }
 
 
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
                FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
        );
    }
 
    public function onRegistrationCompleted(\FOS\UserBundle\Event\FilterUserResponseEvent $event)
    {
        //$user = $event->getForm()->getData();
        //$this->em->persist($user);
        //$this->em->flush();

    }
    public function onRegistrationSuccess(\FOS\UserBundle\Event\FormEvent $event)
    {
        //$rolesArr = array('ROLE_BENEV');
        $rolesArr = 'ROLE_BENEV';
        /** @var $user \FOS\UserBundle\Model\UserInterface */
        /*$user = $event->getAuthenticationToken()->getUser();*/

        $user = $event->getForm()->getData();

        $objData = serialize($user);
        $methodes__ = get_class_methods($user);
        // foreach ($methodes__ as $methode_name) {

        //          $myFile = fopen('/home/sebastien/obj.txt','a+');
        //          fputs($myFile, $user->firstname." ++++ ");
        // }
                
        // fclose($myFile);

        $user->addRole($rolesArr);
        //$user->setPseudo("ROYROY");

        $this->em->persist($user);
        $this->em->flush();

        $url = $this->router->generate('bissap_coreBundle_index');
 
        $event->setResponse(new RedirectResponse($url));
    }
    

}
?>
