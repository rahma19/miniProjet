<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\Destination;
use App\Entity\EtapeCircuit;
use App\Entity\Ville;
use App\Form\CircuitType;
use App\Form\DestType;
use App\Form\VilleType;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CrudController extends AbstractController
{
    /**
     * @Route("/circuit", name="circuit")
     */
    public function Voyage()
    {
        $manager = $this->getDoctrine()->getManager();
        $circuit = $manager->getRepository(Circuit::class)->findAll();
        return $this->render('crud/circuit.html.twig', ['circuits' => $circuit]);
    }

    /**
     * @Route("/deleteCircuit/{id}", name="deleteCirc")
     */
    public function delete(\Symfony\Component\HttpFoundation\Request $request,Circuit $circuit)
    {
        $manager = $this->getDoctrine()->getManager();
        $form = $this->createForm(CircuitType::class,$circuit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->remove($circuit);
            $manager->flush();
            return $this->redirectToRoute('circuit');
        }
        return $this->render('crud/deleteCirc.html.twig', ['formCircuit' => $form->createView()]);
    }

    /**
     * @Route("/createCircuit", name="createCirc")
     * @Route("/modifyCircuit/{id}", name="updateCirc")
     */
    public function update(\Symfony\Component\HttpFoundation\Request $request,Circuit $circuit=null)
    { $manager = $this->getDoctrine()->getManager();
        if (!$circuit) {
            $circuit = new Circuit();
        }
        $form = $this->createForm(CircuitType::class,$circuit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($circuit);
            $manager->flush();
            return $this->redirectToRoute('circuit');
        }
        return $this->render('crud/updateCirc.html.twig', ['formCircuit' => $form->createView(), 'test' => $circuit->getId() !== null]);
    }

    /**
     * @Route("circuit/{id}",name="detailCirc")
     */
    public function circuit($id)
    {
        $em = $this->getDoctrine()->getManager();
        $circ=$em->getRepository(EtapeCircuit::class)->find_circuit_etape();
        $circuit=$em->getRepository(EtapeCircuit::class)->find_circuit($id);
        return $this->render('crud/detailCirc.html.twig', array('circ'=>$circ, 'id' => $id,'circuit'=>$circuit));
    }


}
