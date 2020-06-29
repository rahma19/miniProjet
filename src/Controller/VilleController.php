<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Entity\Ville;
use App\Form\DestType;
use App\Form\VilleType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    /**
     * @Route("/ville", name="ville")
     */
    public function index()
    {
        return $this->render('ville/index.html.twig', [
            'controller_name' => 'VilleController',
        ]);
    }
    /**
     * @Route("/createVle", name="createVille")
     * @Route("/updateVle/{id}", name="updateVille")
     */
    public function update(\Symfony\Component\HttpFoundation\Request $request, Ville $ville = null)
    {
        $manager = $this->getDoctrine()->getManager();
        if (!$ville) {
            $ville = new Ville();
        }
        $form = $this->createForm(VilleType::class,$ville);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ville);
            $manager->flush();
            return $this->redirectToRoute('destination');
        }
        return $this->render('ville/Ville.html.twig', ['formVille' => $form->createView(), 'test' => $ville->getId() !== null]);
    }

    /**
     * @Route("/deleteVle/{id}", name="deleteVille")
     */
    public function delete(\Symfony\Component\HttpFoundation\Request $request,Ville $ville)
    {
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(VilleType::class,$ville);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->remove($ville);
            $manager->flush();
            return $this->redirectToRoute('destination');
        }
        return $this->render('ville/deleteVle.html.twig', ['formVille' => $form->createView()]);
    }

}
