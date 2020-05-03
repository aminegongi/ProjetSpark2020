<?php

namespace PlatBundle\Controller;
use PlatBundle\PlatBundle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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

            foreach ($_FILES['files']['name'] as $name => $value)
            {   if($value!=null){
                $my_file_name = explode(".", $_FILES['files']['name'][$name]);

                //{
                $NewImageName = md5(rand()) . '.' . $my_file_name[1];
                $SourcePath = $_FILES['files']['tmp_name'][$name];
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
        $plat->setImage0($plat->getImage0());
        $plat->setImage1($plat->getImage1());
        $plat->setImage2($plat->getImage2());
        $plat->setImage3($plat->getImage3());
        $plat->setImage4($plat->getImage4());
        $plat->setImage5("");



        $editForm = $this->createForm('PlatBundle\Form\PlatType', $plat)->add('Modifier', SubmitType::class);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if($_FILES['files']['name'][0]) {

                $i = 0;
                $images = array();
                for($j=0; $j<5; $j++){
                    $images[$j] = null;
                }
                foreach ($_FILES['files']['name'] as $name => $value)
                {   if($value!=null) {

                    $my_file_name = explode(".", $_FILES['files']['name'][$name]);

                    //{
                    $NewImageName = md5(rand()) . '.' . $my_file_name[1];
                    $SourcePath = $_FILES['files']['tmp_name'][$name];
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
            }






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
        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();
        dump($csrfToken);
        return $this->render('@Plat/Default/test.html.twig', array(
            'form'=>$form->createView(),
            'csrf_token'=>$csrfToken,
            'error'=>$error,
            'last_username'=>$lastUsername,'user'=>$this->getUser()
        ));
    }


    #Action qui envoi les plats recommendé vers la page
    public function platsRecAction(Request $request){
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
        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();
        #Recuperation Post
        $meteo = array("cold"=>$request->query->get('cold'),"hot"=>$request->query->get('hot'));
        $humeur = array("happy"=>$request->query->get('happy'),"tired"=>$request->query->get('tired'),"motivated"=>$request->query->get('motivated'),"sad"=>$request->query->get('sad'),"calm"=>$request->query->get('calm'));
        $specialite =array("tunisienne"=>$request->query->get('tunisienne'),"italienne"=>$request->query->get('italienne'),"francaise"=>$request->query->get('francaise'),"turque"=>$request->query->get('turque'),"americaine"=>$request->query->get('americaine'),"syrienne"=>$request->query->get('syrienne'));
        array_replace(array_values($specialite),array('on','on','on','on','on','on'));
        //$specialite = array_map(function(array_values($specialite)) { return 'on'; }, $specialite);
        $temps = array("tcuisson"=>$request->query->get('tcuisson'),"tprepa"=>$request->query->get('tprepa'),"ttotal"=>$request->query->get('tprepa')+$request->query->get('tcuisson'));
        $typePlat=array("entre"=>$request->query->get('entre'),"plat principal"=>$request->query->get('platPrincipal'),"dessert"=>$request->query->get('dessert'),"boisson"=>$request->query->get('boisson'));
        $hfr=$request->query->get('hfr');
        $formulaireData= array($meteo,$humeur,$specialite,$temps,$typePlat,$hfr);
        dump($formulaireData);

        #Fin reccuperation
        $em = $this->getDoctrine()->getManager();
        $recPlats=array();
       $count = ($platId = $this->getDoctrine()->getRepository(Plat::class)->AdvSearchPlat($formulaireData)[0]);
        for ($i=0;$i<$count;$i++){
            $platId = $this->getDoctrine()->getRepository(Plat::class)->AdvSearchPlat($formulaireData)[1][$i];

            $plat = $em->getRepository(Plat::class)->find($platId["id"]);
            array_push($recPlats,$plat);
        }
        #Traiter les autres cas !
        dump($recPlats);
        return $this->render('@Plat/Default/PlatRecommande.html.twig', array(
            'form'=>$form->createView(),
            'csrf_token'=>$csrfToken,
            'error'=>$error,
            'last_username'=>$lastUsername,
            'recPlats'=>$recPlats,'user'=>$this->getUser()
        ));
    }

    public function showFormulaireAction(Request $request){
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
        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();
        return $this->render('@Plat/Default/PlatsRec.html.twig', array(
            'form'=>$form->createView(),
            'csrf_token'=>$csrfToken,
            'error'=>$error,
            'last_username'=>$lastUsername,'user'=>$this->getUser()
        ));

}




    #get un seul plat front
    public function getPlatAction(Request $request,$id)
    {     /** @var $session Session */
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
        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();
        $em=$this->getDoctrine()->getManager();
        $plat = $em->getRepository(Plat::class)->find($id);
        $pattern = '/#(([0-9]*)|([0-9]*.[0-9]*))#/';
        $portion=$plat->getNbrPortion();
        $chaineOutput=preg_replace_callback($pattern,  function ($matches) use($portion ) {
            return $matches[1]* $portion;
        }, $plat->getIngredient(), -1 );

        return  $this->render('@Plat/Default/unSeulPlat.html.twig',array(
            'form'=>$form->createView(),
            'csrf_token'=>$csrfToken,
            'error'=>$error,
            'last_username'=>$lastUsername,
            'plat'=>$plat,
            'ingredientsInit'=>$chaineOutput,
            'user'=>$this->getUser(),
        ));
    }

    public function afterRequestAction(Request $request){
        $response = $request->get('portion');
        $response2 = $request->get('ing');
        $pattern = '/#(([0-9]*)|([0-9]*.[0-9]*))#/';
        $chaineOutput=preg_replace_callback($pattern,  function ($matches) use($response) {
            return $matches[1]*$response;
        }, $response2, -1 );

        return new JsonResponse(array('response2' => $chaineOutput));
    }

    public function rechSimpleAction(Request $request)
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
        $csrfToken = $this->tokenManager;
        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();

        $em=$this->getDoctrine()->getRepository(Plat::class);
        $list = $em->findAll();

        return $this->render('@Plat/Default/recherchePlat.html.twig', array(
            'form'=>$form->createView(),
            'csrf_token'=>$csrfToken,
            'error'=>$error,
            'last_username'=>$lastUsername,
            'listPlats'=>$list,'user'=>$this->getUser()
        ));
    }
}
