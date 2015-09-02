<?php

namespace AWBundle\Controller;

use AWBundle\Form\AwForm;
use AWBundle\Form\awType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AWBundle\Entity\awuser;
use AWBundle\Entity\aw;

define("RESPONSE_NO",  0);
define("RESPONSE_YES",  1);
define("RESPONSE_MAYBE",  2);
define("RESPONSE_WAITING",  3);


class AWController extends Controller
{

  public function userSuccessAction() {

    return $this->render('AWBundle:Default:sucess.html.twig');

  }

  public function detailAwAction($id, Request $request)
  {
    $form = $this->createFormBuilder()
                  ->add('email', 'text')
                  ->add('send invit', 'submit')
                  ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {

        $em = $this->getDoctrine()->getManager();

        // We first get the Id of the user
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user = $userManager->findUserBy(array('email' => $form->get('email')->getData()));

        /*$logger = $this->get('logger');
        $logger->debug('logger user');
        $logger->debug(print_r($user->getId(), true)); */

        //TODO: check if email exists in the DB -> $user is not null
        if($user->getId()) {
          // Current logged user
          $userCurrent = $this->container->get('security.context')->getToken()->getUser();

          //We have found the user
          $awuser = new awuser();
          $awuser->setUserId($user->getId());
          $awuser->setAwId($id);
          $awuser->setAwuserAnswer(RESPONSE_WAITING);
          $awuser->setAwuserInvitedby($userCurrent->getId());

          // Save in DB
          $em->persist($awuser);
          $em->flush();
        }
        else {
          // TODO: display error
          //return $this->redirect($this->generateUrl('show_aw'));
        }

    }

    $em = $this->container->get('doctrine')->getManager();

    $qb = $em->createQueryBuilder();

    // THIS IS WORKING FROM HERE ...
    /*$qb = $em->createQuery(
                'SELECT a, c FROM AWBundle:awuser a
                JOIN AWBundle:aw c
                WITH a.aw_id = c.id');

     $aw = $qb->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR); */
     /*  WHERE p.id = :id'
     )->setParameter('id', $id); */
    // .... TO HERE

    //TODO: We are doing 2 queries here, not sure how to merge that in one
     $qb->select('awuser')
         ->from('AWBundle:awuser', 'awuser')
         ->leftJoin('AWBundle:aw', 'aw')
         ->where('aw.id = awuser.aw_id')
         ->andWhere('awuser.aw_id = :motcle')
         ->setParameter('motcle', $id)
         ->addSelect('aw');

     $query = $qb->getQuery();
     $aw = $query->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);

     $qb2 = $em->createQueryBuilder();

     $qb2->select('awuser')
         ->from('AWBundle:awuser', 'awuser')
         ->leftJoin('AWBundle:User', 'user')
         ->where('user.id = awuser.user_id ')
         ->andWhere('awuser.aw_id = :motcle')
         ->setParameter('motcle', $id)
         ->addSelect('user');

    $query = $qb2->getQuery();
    $aw2 = $query->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);

    /*$logger = $this->get('logger');
    $logger->debug('logger db');
    $logger->debug(print_r($aw, true));*/

    return $this->container->get('templating')->renderResponse('AWBundle:Default:detailAw.html.twig', array(
        'aw' => $aw, 'aw2' => $aw2,'formInvite' => $form->createView()
        ));
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
                    ->where("a.aw_title LIKE :motcle")
                    ->orderBy('a.aw_title', 'ASC')
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

  $formSearch = $this->container->get('form.factory')->create(new AwForm());

  $awNew = new aw();
  $awNew->setAwDate(new \DateTime('tomorrow'));

  /*$form = $this->createFormBuilder($awNew)
                ->add('aw_visibility', 'checkbox')
                ->add('aw_status', 'checkbox')
                ->add('aw_date', 'date')
                ->add('aw_title', 'text')
                ->add('aw_ad', 'checkbox')
                ->add('awSave', 'submit')
                ->getForm(); */

  $form = $this->createForm(new awType(), $awNew);

  $form->handleRequest($request);

  if ($form->isValid()) {
      // Save in DB
      $em = $this->getDoctrine()->getManager();
      //$awNew = $form->getData();
      $em->persist($awNew);
      $em->flush();
      //return $this->redirect($this->generateUrl('show_aw'));
  }

  $em = $this->container->get('doctrine')->getManager();

  $aw = $em->getRepository('AWBundle:aw')->findAll();

  return $this->container->get('templating')->renderResponse('AWBundle:Default:aw.html.twig', array(
    'aw' => $aw,  'formSearch' => $formSearch->createView(), 'formCreate' => $form->createView()  ));

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

  /*TODO: IS THIS STILL NEEDED ? MIGht NEED TO REMOVE */
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

 /*TODO: IS THIS STILL NEEDED ? MIGht NEED TO REMOVE */
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
