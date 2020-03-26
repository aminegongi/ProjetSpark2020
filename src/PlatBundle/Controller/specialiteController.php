<?php

namespace PlatBundle\Controller;

use PlatBundle\Entity\specialite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Specialite controller.
 *
 */
class specialiteController extends Controller
{
    /**
     * Lists all specialite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $specialites = $em->getRepository('PlatBundle:specialite')->findAll();

        return $this->render('specialite/index.html.twig', array(
            'specialites' => $specialites,
        ));
    }

    /**
     * Creates a new specialite entity.
     *
     */
    public function newAction(Request $request)
    {
        $specialite = new Specialite();
        $form = $this->createForm('PlatBundle\Form\specialiteType', $specialite)->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($_FILES['platbundle_specialite']['name'] as $name => $value)
            {
                $my_file_name = explode(".", $_FILES['platbundle_specialite']['name'][$name]);

                //{
                $NewImageName = md5(rand()) . '.' . $my_file_name[1];
                $SourcePath = $_FILES['platbundle_specialite']['tmp_name'][$name];
                $TargetPath = "images/specialite/".$NewImageName;

                move_uploaded_file($SourcePath, $TargetPath);
            }
            $specialite->setImage($TargetPath);
            $em = $this->getDoctrine()->getManager();
            $em->persist($specialite);
            $em->flush();

            return $this->redirectToRoute('specialite_index', array('id' => $specialite->getId()));
        }

        return $this->render('specialite/new.html.twig', array(
            'specialite' => $specialite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a specialite entity.
     *
     */
    public function showAction(specialite $specialite)
    {
        $deleteForm = $this->createDeleteForm($specialite);

        return $this->render('specialite/show.html.twig', array(
            'specialite' => $specialite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing specialite entity.
     *
     */
    public function editAction(Request $request, specialite $specialite)
    {
        $specialite->setImage("");
        $editForm = $this->createForm('PlatBundle\Form\specialiteType', $specialite)->add('Modifier', SubmitType::class);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            foreach ($_FILES['platbundle_specialite']['name'] as $name => $value)
            {
                $my_file_name = explode(".", $_FILES['platbundle_specialite']['name'][$name]);

                //{
                $NewImageName = md5(rand()) . '.' . $my_file_name[1];
                $SourcePath = $_FILES['platbundle_specialite']['tmp_name'][$name];
                $TargetPath = "images/specialite/".$NewImageName;

                move_uploaded_file($SourcePath, $TargetPath);
            }
            $specialite->setImage($TargetPath);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specialite_index', array('id' => $specialite->getId()));
        }

        return $this->render('specialite/edit.html.twig', array(
            'specialite' => $specialite,
            'form' => $editForm->createView(),

        ));
    }

    /**
     * Deletes a specialite entity.
     *
     */
    public function deleteAction(Request $request, specialite $specialite)
    {
        $em = $this->getDoctrine();
        $note = $em->getRepository(specialite::class)->find($specialite);
        $em->getManager()->remove($specialite);
        $em->getManager()->flush();
        return $this->redirectToRoute('specialite_index');
    }



}
