<?php
// src/AppBundle/Controller/DefaultController.php

// ...
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/AW/product")
     */
  public function createAction()
  {
      $product = new Product();
      $product->setName('A Foo Bar');
      $product->setPrice('19.99');
      $product->setDescription('Lorem ipsum dolor');

      $em = $this->getDoctrine()->getManager();

      $em->persist($product);
      $em->flush();

      return new Response('Created product id '.$product->getId());
  }
}
