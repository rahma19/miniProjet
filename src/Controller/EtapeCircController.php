<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\EtapeCircuit;
use App\Form\CircuitType;
use App\Form\EtapeCircuitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EtapeCircController extends AbstractController
{
    /**
     * @Route("/etape/circ", name="etape_circ")
     */
    public function index()
    {
        return $this->render('etape_circ/index.html.twig', [
            'controller_name' => 'EtapeCircController',
        ]);
    }
    /**
     * @Route("/deleteEtape/{id}", name="deleteEtape")
     */
    public function delete(\Symfony\Component\HttpFoundation\Request $request,EtapeCircuit $etapeCircuit)
    {
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(EtapeCircuitType::class,$etapeCircuit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->remove($etapeCircuit);
            $manager->flush();
            return $this->redirectToRoute('circuit');
        }
        return $this->render('etape_circ/delete.html.twig', ['formEtapeCirc' => $form->createView()]);
    }

    /**
     * @Route("/create", name="createEtape")
     * @Route("/update/{id}", name="updateEtape")
     */
    public function update(\Symfony\Component\HttpFoundation\Request $request,EtapeCircuit $etapeCircuit=null)
    { $manager = $this->getDoctrine()->getManager();
        if (!$etapeCircuit) {
            $etapeCircuit = new EtapeCircuit();
        }
        $form = $this->createForm(EtapeCircuitType::class,$etapeCircuit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($etapeCircuit);
            $manager->flush();
            return $this->redirectToRoute('circuit');
        }
        return $this->render('etape_circ/update.html.twig', ['formEtapeCirc' => $form->createView(), 'test' => $etapeCircuit->getId() !== null]);
    }

}
