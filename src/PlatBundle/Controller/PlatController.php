<?php

namespace PlatBundle\Controller;

use PlatBundle\Entity\Plat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
/**
 * Plat controller.
 *
 */
class PlatController extends Controller
{
    //needed for loogin from popup
    private $tokenManager;
    public function __construct(CsrfTokenManagerInterface $tokenManager = null)
    {
        $this->tokenManager = $tokenManager;
    }

    /**
     * Lists all plat entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $plats = $em->getRepository('PlatBundle:Plat')->findAll();

        return $this->render('plat/index.html.twig', array(
            'plats' => $plats,
        ));
    }

    /**
     * Creates a new plat entity.
     *
     */
    public function newAction(Request $request)
    {

        $plat = new Plat();
        $form = $this->createForm('PlatBundle\Form\PlatType', $plat)->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $images = array();
            for($j=0; $j<5; $j++){
                $images[$j] = null;
            }
            $i = 0;
            foreach ($_FILES['platbundle_plat']['name'] as $name => $value)
            {   if($value!=null){
                $my_file_name = explode(".", $_FILES['platbundle_plat']['name'][$name]);

                //{
                $NewImageName = md5(rand()) . '.' . $my_file_name[1];
                $SourcePath = $_FILES['platbundle_plat']['tmp_name'][$name];
                $TargetPath = "images/imagePlats/".$NewImageName;

                move_uploaded_file($SourcePath, $TargetPath);
                $images[$i] = $TargetPath;
                $i++;
            }
            }

            $plat->setImage0($images[0]);
            $plat->setImage1($images[1]);
            $plat->setImage2($images[2]);
            $plat->setImage3($images[3]);
            $plat->setImage4($images[4]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($plat);
            $em->flush();

            return $this->redirectToRoute('plat_show', array('id' => $plat->getId()));
        }

        return $this->render('plat/new.html.twig', array(
            'plat' => $plat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a plat entity.
     *
     */
    public function showAction(Plat $plat)
    {
        $deleteForm = $this->createDeleteForm($plat);

        return $this->render('plat/show.html.twig', array(
            'plat' => $plat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing plat entity.
     *
     */
    public function editAction(Request $request, Plat $plat)
    {
        $plat->setImage0("");
        $plat->setImage1("");
        $plat->setImage2("");
        $plat->setImage3("");
        $plat->setImage4("");



        $editForm = $this->createForm('PlatBundle\Form\PlatType', $plat)->add('Modifier', SubmitType::class);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $i = 0;
            $images = array();
            for($j=0; $j<5; $j++){
                $images[$j] = null;
            }
            foreach ($_FILES['platbundle_plat']['name'] as $name => $value)
            {   if($value!=null) {

                $my_file_name = explode(".", $_FILES['platbundle_plat']['name'][$name]);

                //{
                $NewImageName = md5(rand()) . '.' . $my_file_name[1];
                $SourcePath = $_FILES['platbundle_plat']['tmp_name'][$name];
                $TargetPath = "images/imagePlats/" . $NewImageName;

                move_uploaded_file($SourcePath, $TargetPath);
                $images[$i] = $TargetPath;
                $i++;
            }
            }


            $plat->setImage0($images[0]);
            $plat->setImage1($images[1]);
            $plat->setImage2($images[2]);
            $plat->setImage3($images[3]);
            $plat->setImage4($images[4]);


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plat_index');
        }

        return $this->render('plat/edit.html.twig', array(
            'plat' => $plat,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a plat entity.
     *
     */
    public function deleteAction(Request $request, Plat $plat)
    {
        $em = $this->getDoctrine();
        $note = $em->getRepository(Plat::class)->find($plat);
        $em->getManager()->remove($plat);
        $em->getManager()->flush();
        return $this->redirectToRoute('plat_index');
    }

    /**
     * Creates a form to delete a plat entity.
     *
     * @param Plat $plat The plat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plat $plat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('plat_delete', array('id' => $plat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    public function testAction(Request $request){
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
        $csrfToken = $this->tokenManager;
        return $this->render('@Plat/Default/test.html.twig', array(
            'csrf_token'=>$csrfToken,
            'error'=>$error,
            'last_username'=>$lastUsername
        ));
    }
}
