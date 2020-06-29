<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\Destination;
use App\Entity\EtapeCircuit;
use App\Entity\Ville;
use App\Form\DestType;
use Doctrine\DBAL\Driver\AbstractOracleDriver\EasyConnectString;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AppController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(\Symfony\Component\HttpFoundation\Request $request)
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
    /**
     * @Route("/destination/{id}",name="detailDest")
     */
    public function detail($id)
    {   $em=$this->getDoctrine()->getManager();
        $detail=$em->getRepository(Destination::class)->find($id);
        return $this->render('app/detail.html.twig',array('dest'=>$detail,'id'=>$id));
    }
  /**
   * @Route("/home", name="home", methods={"GET", "POST"})
   * @Route("", name="h", methods={"GET", "POST"})
   */
    public function home()
    {
        return $this->render('app/home.html.twig');
    }

public function destination()
{   $em=$this->getDoctrine()->getManager();
    $dest= $this->getDoctrine()->getRepository(Destination::class)->findAll();
     return $this->render('app/destination.html.twig',array('destination'=>$dest));
}

    /**
     * @Route("/update", name="create")
     * @Route("/new/{id}", name="update")
     */
    public function update(\Symfony\Component\HttpFoundation\Request $request, Destination $destination = null)
    {
        $manager = $this->getDoctrine()->getManager();
        if (!$destination) {
            $destination = new Destination();
        }
        $form = $this->createForm(DestType::class, $destination);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($destination);
            $manager->flush();
            return $this->redirectToRoute('destination');
        }
        return $this->render('app/update.html.twig', ['t' => false, 'formDest' => $form->createView(), 'test' => $destination->getId() !== null]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(\Symfony\Component\HttpFoundation\Request $request, Destination $destination)
    {
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(DestType::class, $destination);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->remove($destination);
            $manager->flush();
            return $this->redirectToRoute('destination');
        }
        return $this->render('app/delete.html.twig', ['formDest' => $form->createView()]);
    }
}
