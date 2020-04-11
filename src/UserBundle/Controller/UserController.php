<?php

namespace UserBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use MaladieBundle\Repository\MaladieRepository;
use MaladieBundle\Repository\MaladieUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UserBundle\Entity\User;

class UserController extends Controller
{
    public function editProfileAction(){

        if(!$this->getUser()){
            return $this->redirectToRoute('login');
        }
        $formFactory = $this->get('fos_user.change_password.form.factory');
        $formPass = $formFactory->createForm();
        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
        $userMaladie= $this->getDoctrine()->getRepository(User::class )->getMaladieOfUser($this->getUser()->getId());
        $allMaladie= $this->getDoctrine()->getRepository(User::class )->getAllMaladie();
        return $this->render('@User/Default/editProfile.html.twig', array('user'=>$user, 'formPass'=>$formPass->createView(),'maladies'=>$userMaladie,'allMaladie'=>$allMaladie));

    }

    public function infosPersoAction(Request $request){

            $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
            if($request->get('nom')!== null && $request->get('nom')!== ""){
                $user->setNom($request->get('nom'));
            }
            if($request->get('prenom')!== null && $request->get('prenom')!== ""){
                $user->setPrenom($request->get('prenom'));
            }
            if($request->get('sexe')!== null && $request->get('sexe')!== ""){
                $user->setSexe($request->get('sexe'));
            }
            $em  =  $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

        return $this->redirectToRoute('editProfile');


    }

    public function afterRequestAddMaladieAction(Request $request){
        $idMaladie = $request->get('idMaladie');
        dump($idMaladie);
        $this->getDoctrine()->getRepository(User::class )->addMaladieToUser($this->getUser()->getId(),$idMaladie);

        return new JsonResponse();;
    }
    public function afterRequestDeleteMaladieAction(Request $request){
        $idMaladie = $request->get('idMaladie');
        //dump($idMaladie);
        $this->getDoctrine()->getRepository(User::class )->deleteMaladieFromUser($this->getUser()->getId(),$idMaladie);

        return new JsonResponse();;
    }
}
