<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class DefaultController extends Controller
{    //needed for loogin from popup
    private $tokenManager;
    public function __construct(CsrfTokenManagerInterface $tokenManager = null)
    {
        $this->tokenManager = $tokenManager;
    }
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

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

        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;
        //$csrfToken = $this->tokenManager;
        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();
        return $this->render('default/acceuilNew.html.twig', array(
            'form'=>$form->createView(),
            'csrf_token'=>$csrfToken,
            'error'=>$error,
            'last_username'=>$lastUsername,'user'=>$this->getUser()
        ));
    }

    /**
     * @Route("/rederict", name="redirection")
     */
    public function backAction()
    {
        $authChecker=$this->container->get('security.authorization_checker');

        if ($authChecker->isGranted('ROLE_ADMIN'))
        {
            return $this->redirectToRoute("admin");
        }
        else
        {
            return $this->redirectToRoute("homepage");
        }
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        return $this->render('backOffice/index.html.twig');
    }

    /**
     * @Route("/base", name="base")
     */
    public function renderRegisterFormAction(Request $request)
    {


//        if ($request->isXMLHttpRequest()) {
//            $formFactory = $this->get('fos_user.registration.form.factory');
//            $form = $formFactory->createForm();
//            return new JsonResponse(array('form' => 'yessine'));
//        }
//        return new Response('This is not ajax!', 400);
        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();
        return $this->render('frontOffice/registerForm.html.twig',array('form'=>$form->createView()));
    }


    /**
     * @Route("/contactez-nous", name="contact")
     */
    public function contactAction(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

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

        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;
        //$csrfToken = $this->tokenManager;
        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();
        return $this->render('contact/contact.html.twig', array(
            'form'=>$form->createView(),
            'csrf_token'=>$csrfToken,
            'error'=>$error,
            'last_username'=>$lastUsername,'user'=>$this->getUser()
        ));
    }




}
