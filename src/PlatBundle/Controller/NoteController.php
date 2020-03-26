<?php

namespace PlatBundle\Controller;

use PlatBundle\Entity\Note;
use PlatBundle\Form\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Note controller.
 *
 */
class NoteController extends Controller
{
    /**
     * Lists all note entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notes = $em->getRepository('PlatBundle:Note')->findAll();

        return $this->render('note/index.html.twig', array(
            'notes' => $notes,
        ));
    }

    /**
     * Creates a new note entity.
     *
     */
    public function newAction(Request $request)
    {
        $note = new Note();
        $form = $this->createForm('PlatBundle\Form\NoteType', $note)->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $note->setNomDesc($note->getNom()." : ".$note->getDescreption());
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('note_index', array('id' => $note->getId()));
        }

        return $this->render('note/new.html.twig', array(
            'note' => $note,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a note entity.
     *
     */
    public function showAction(Note $note)
    {
        $deleteForm = $this->createDeleteForm($note);

        return $this->render('note/show.html.twig', array(
            'note' => $note,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing note entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $note = $this->getDoctrine()->getRepository(Note::class)->find($id);
        $editForm = $this->createForm(NoteType::class, $note)->add('Modifier', SubmitType::class);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->persist($note);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/edit.html.twig',
            array('form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a note entity.
     *
     */
    public function deleteAction(Request $request, Note $note)
    {

        $em = $this->getDoctrine();
        $note = $em->getRepository(Note::class)->find($note);
        $em->getManager()->remove($note);
        $em->getManager()->flush();
        return $this->redirectToRoute('note_index');
    }

    /**
     * Creates a form to delete a note entity.
     *
     * @param Note $note The note entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Note $note)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('note_delete', array('id' => $note->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
