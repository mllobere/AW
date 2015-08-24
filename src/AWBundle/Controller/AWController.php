<?php

namespace AWBundle\Controller;

use AWBundle\Resources\Form\AwForm;
use AWBundle\Resources\Form\CreateAwForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AWBundle\Entity\awuser;
use AWBundle\Entity\aw;


class AWController extends Controller
{

  public function userSuccessAction() {

    return $this->render('AWBundle:Default:sucess.html.twig');

  }

  public function searchAWAction()
  {
      $request = $this->container->get('request');

      if($request->isXmlHttpRequest())
      {
          $motcle = '';
          $motcle = $request->request->get('motcle');

          $em = $this->container->get('doctrine')->getEntityManager();

          //$aw = $em->getRepository('AWBundle:aw')->findAll();

          /*$aw = $this->getDoctrine()
              ->getRepository('AWBundle:aw')
              ->findAll(); */

          if($motcle != '')
          {
                 $qb = $em->createQueryBuilder();

                 $qb->select('a')
                    ->from('AWBundle:aw', 'a')
                    ->where("a.place LIKE :motcle")
                    ->orderBy('a.place', 'ASC')
                    ->setParameter('motcle', '%'.$motcle.'%');

                 $query = $qb->getQuery();
                 $aw = $query->getResult();
                 //$aw = $em->getRepository('AWBundle:aw')->findAll();
          }
          else {
              $aw = $em->getRepository('AWBundle:aw')->findAll();
          }

          return $this->container->get('templating')->renderResponse('AWBundle:Default:listAw.html.twig', array(
              'aw' => $aw
              ));
      }
      else {
          return $this->showAwAction();
      }
  }

public function showAwAction(Request $request) {

  $aw = new aw();

  $formSearch = $this->container->get('form.factory')->create(new AwForm());
  $formCreate = $this->createForm(new CreateAwForm($aw));

  $formCreate->handleRequest($request);

  if ($formCreate->isValid()) {
      // Save in DB
      $em = $this->getDoctrine()->getManager();
      $em->persist($aw);
      $em->flush();
      
      //TODO:FIX THE REDIRECT URL
  }


  $em = $this->container->get('doctrine')->getManager();

  $aw = $em->getRepository('AWBundle:aw')->findAll();

  return $this->container->get('templating')->renderResponse('AWBundle:Default:aw.html.twig', array(
    'aw' => $aw,  'formSearch' => $formSearch->createView(), 'formCreate' => $formCreate->createView()  ));

}

  public function showAwAction2(Request $request) {

    //$formSearch = $this->container->get('form.factory')->create(new AwForm());
    $formSearch = $this->createForm(new AwForm());

    /*$form2 = $this->createFormBuilder()
        ->add('placeSearch', 'text')
        ->add('dateSearch', 'date')
        ->add('search', 'submit')
        ->getForm();

    $form2->handleRequest($request); */

    /*$repository = $this->getDoctrine()->getRepository('AWBundle:aw');
    $query = $repository->createQueryBuilder('p')
                   ->where('p.place LIKE :place')
                   ->setParameter('place', '%'.$form2->get('placeSearch')->getData().'%')
                   ->getQuery();
    $awAll = $query->getResult();

    if (!$awAll) {
        //throw $this->createNotFoundException(
        //    'No AW found'
        //);
    } */

    $aw = new aw();
    $aw->setName('AwName');
    $aw->setPlace('AwPlace');
    $aw->setDate(new \DateTime('tomorrow'));

    $form = $this->createFormBuilder($aw)
        ->add('name', 'text')
        ->add('place', 'text')
        ->add('date', 'date')
        ->add('idUser', 'integer')
        ->add('create', 'submit')
        ->getForm();

    // TODO : we should not have the idUser in the form, this should be transparent
    if($this->getUser() != null) {
      $form->get('idUser')->setData($this->getUser()->getId());
    }
    else {

    }

    $form->handleRequest($request);

    if ($form->isValid()) {
        // Save in DB
        $em = $this->getDoctrine()->getManager();
        $em->persist($aw);
        $em->flush();
        //TODO:FIX THE REDIRECT URL
        //return $this->redirect($this->generateUrl('userSuccess'));
    }

    $em = $this->container->get('doctrine')->getEntityManager();
    $qb = $em->createQueryBuilder();

    $motcle = 'temple';

    $qb->select('a')
       ->from('AWBundle:aw', 'a')
       ->where("a.place LIKE :motcle")
       ->orderBy('a.place', 'ASC')
       ->setParameter('motcle', '%'.$motcle.'%');

    $query = $qb->getQuery();
    $aw2 = $query->getResult();

  //  return $this->render('AWBundle:Default:user.html.twig'

  /*  $this->container->get('templating')->renderResponse('AWBundle:Default:listAw.html.twig', array(
  		'aw' => $aw2,
  		'formSearch' => $formSearch->createView()
  	)); */

    return $this->render('AWBundle:Default:aw.html.twig', array(
      'aw' => $aw2,  'formSearch' => $formSearch->createView() ));

  }


  public function createAwAction2(Request $request) {

    $aw = new aw();
    $aw->setName('AwName');
    $aw->setPlace('AwPlace');
    $aw->setDate(new \DateTime('tomorrow'));

    $form = $this->createFormBuilder($aw)
        ->add('name', 'text')
        ->add('place', 'text')
        ->add('date', 'date')
        ->add('create', 'submit')
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        // Save in DB
        $em = $this->getDoctrine()->getManager();
        $em->persist($aw);
        $em->flush();
        //TODO:FIX THE REDIRECT URL
        //return $this->redirect($this->generateUrl('userSuccess'));
    }

    return $this->render('AWBundle:Default:createAw.html.twig', array(
        'form' => $form->createView(),
    ));
  }

  public function showUserAction()
  {
      $awuser = $this->getDoctrine()
          ->getRepository('AWBundle:awuser')
          ->findAll();

      if (!$awuser) {
          throw $this->createNotFoundException(
              'No user found'
          );
      }

      return $this->render('AWBundle:Default:user.html.twig', array(
          'word' => $awuser));

  }


  public function indexAction(Request $request) {

    $form = $this->createFormBuilder()
        ->add('place', 'text')
        ->add('date', 'date')
        ->add('GO', 'submit')
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
      return $this->redirect($this->generateUrl('show_aw'));
     /*
      $this->getDoctrine()->getRepository('AcmeDemoBundle:Pony')
         ->findBy($form->getData()->toArray());

      $awAll = $this->getDoctrine()
          ->getRepository('AWBundle:aw')
          ->findAll();

      if (!$awAll) {
          throw $this->createNotFoundException(
              'No AW found'
          );
      }*/

    }

    return $this->render('AWBundle:Default:index.html.twig', array(
        'form' => $form->createView(),
    ));

  }

  public function createUserAction(Request $request)
  {
        $awuser = new awuser();
        $awuser->setFirstname('FirstName');
        $awuser->setLastname('LastName');
        $awuser->setGender('Gender');

        $form = $this->createFormBuilder($awuser)
            ->add('firstname', 'text')
            ->add('lastname', 'text')
            ->add('gender', 'text')
            ->add('create', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            // Save in DB
            $em = $this->getDoctrine()->getManager();
            $em->persist($awuser);
            $em->flush();
            //TODO:FIX THE REDIRECT URL
            //return $this->redirect($this->generateUrl('userSuccess'));
        }

        return $this->render('AWBundle:Default:createUser.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
