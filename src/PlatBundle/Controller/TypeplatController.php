<?php

namespace PlatBundle\Controller;

use PlatBundle\Entity\Typeplat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Typeplat controller.
 *
 */
class TypeplatController extends Controller
{
    /**
     * Lists all typeplat entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeplats = $em->getRepository('PlatBundle:Typeplat')->findAll();

        return $this->render('typeplat/index.html.twig', array(
            'typeplats' => $typeplats,
        ));
    }

    /**
     * Creates a new typeplat entity.
     *
     */
    public function newAction(Request $request)
    {
        $typeplat = new Typeplat();
        $form = $this->createForm('PlatBundle\Form\TypeplatType', $typeplat)->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeplat);
            $em->flush();

            return $this->redirectToRoute('typeplat_index');
        }

        return $this->render('typeplat/new.html.twig', array(
            'typeplat' => $typeplat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeplat entity.
     *
     */
    public function showAction(Typeplat $typeplat)
    {
        $deleteForm = $this->createDeleteForm($typeplat);

        return $this->render('typeplat/show.html.twig', array(
            'typeplat' => $typeplat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeplat entity.
     *
     */
    public function editAction(Request $request, Typeplat $typeplat)
    {
        $editForm = $this->createForm('PlatBundle\Form\TypeplatType', $typeplat)->add('Modifier', SubmitType::class);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typeplat_index', array('id' => $typeplat->getId()));
        }

        return $this->render('typeplat/edit.html.twig', array(
            'typeplat' => $typeplat,
            'form' => $editForm->createView(),

        ));
    }

    /**
     * Deletes a typeplat entity.
     *
     */
    public function deleteAction(Request $request, Typeplat $typeplat)
    {
        $em = $this->getDoctrine();
        $note = $em->getRepository(Typeplat::class)->find($typeplat);
        $em->getManager()->remove($typeplat);
        $em->getManager()->flush();
        return $this->redirectToRoute('typeplat_index');
    }

    /**
     * Creates a form to delete a typeplat entity.
     *
     * @param Typeplat $typeplat The typeplat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typeplat $typeplat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typeplat_delete', array('id' => $typeplat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
