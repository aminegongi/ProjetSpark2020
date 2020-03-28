<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
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
            return $this->redirectToRoute("fos_user_profile_show");
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





}
