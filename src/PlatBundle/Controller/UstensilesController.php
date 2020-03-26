<?php

namespace PlatBundle\Controller;

use PlatBundle\Entity\Ustensiles;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ustensile controller.
 *
 */
class UstensilesController extends Controller
{
    /**
     * Lists all ustensile entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ustensiles = $em->getRepository('PlatBundle:Ustensiles')->ustensilesAlphabeticalOrderForDisplay();

        return $this->render('ustensiles/index.html.twig', array(
            'ustensiles' => $ustensiles,
        ));
    }

    /**
     * Creates a new ustensile entity.
     *
     */
    public function newAction(Request $request)
    {
        $ustensile = new Ustensiles();
        $form = $this->createForm('PlatBundle\Form\UstensilesType', $ustensile)->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ustensile);
            $em->flush();

            return $this->redirectToRoute('ustensiles_index');
        }

        return $this->render('ustensiles/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ustensile entity.
     *
     */
    public function showAction(Ustensiles $ustensile)
    {

        return $this->render('ustensiles/show.html.twig', array(
            'ustensile' => $ustensile,
        ));
    }

    /**
     * Displays a form to edit an existing ustensile entity.
     *
     */
    public function editAction(Request $request, Ustensiles $ustensile)
    {

        $editForm = $this->createForm('PlatBundle\Form\UstensilesType', $ustensile)->add('Modifier', SubmitType::class);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ustensiles_index');
        }

        return $this->render('ustensiles/edit.html.twig', array(
            'ustensile' => $ustensile,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a ustensile entity.
     *
     */
    public function deleteAction(Request $request, Ustensiles $ustensile)
    {
        $em = $this->getDoctrine();
        $note = $em->getRepository(Ustensiles::class)->find($ustensile);
        $em->getManager()->remove($ustensile);
        $em->getManager()->flush();
        return $this->redirectToRoute('ustensiles_index');
    }

    /**
     * Creates a form to delete a ustensile entity.
     *
     * @param Ustensiles $ustensile The ustensile entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ustensiles $ustensile)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ustensiles_delete', array('id' => $ustensile->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
