<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

use Symfony\Component\HttpFoundation\Request;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */

     
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

     /**
     * @Route("/entreprises", name="entreprises")
     */
    public function entreprise(): Response
    {

        $liste_entreprises= $this->getDoctrine()->getRepository(Entreprise::class)->findAll();
        

        return $this->render('accueil/entreprise.html.twig', ['liste_entreprises'=>$liste_entreprises]);
    }

    /**
     * @Route("/formations", name="formations")
     */
    public function formation(): Response
    {
        $liste_formations= $this->getDoctrine()->getRepository(Formation::class)->findAll();
        return $this->render('accueil/formation.html.twig', [
            'liste_formations'=>$liste_formations
        ]);
    }

    /**
     * @Route("/stages", name="stages")
     */
    public function stage(): Response
    {
        $stages= $this->getDoctrine()->getRepository(Stage::class)->findAll();
        return $this->render('accueil/stage.html.twig', ['liste_stages'=>$stages]);
    }

    /**
     * @Route("/accueil/stages/{id_stage}", name="detailStage")
     */
    public function detailStage($id_stage): Response
    {
        $unStage= $this->getDoctrine()->getRepository(Stage::class)->find($id_stage);
        return $this->render('accueil/detailStage.html.twig', [
            'unStage'=>$unStage
        ]);
    }

    /**
     * @Route("/accueil/entreprises/{id_entreprise}", name="detailEntreprise")
     */
    public function detailEntreprise($id_entreprise): Response
    {
        $uneEntreprise= $this->getDoctrine()->getRepository(Entreprise::class)->find($id_entreprise);
        return $this->render('accueil/detailEntreprise.html.twig', [
            'uneEntreprise'=>$uneEntreprise
        ]);
    }

    /**
     * @Route("/accueil/formations/{id_formation}", name="stageFormation")
     */
    public function stageFormation($id_formation): Response
    {
        $uneFormation= $this->getDoctrine()->getRepository(Formation::class)->find($id_formation);
        return $this->render('accueil/stageFormation.html.twig', [
            'uneFormation'=>$uneFormation
        ]);
    }
    
    /**
     * @Route("/formulaireEntreprise", name="formulaireEntreprise")
     */
    public function ajouterEntreprise(Request $requeteHttp){
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this   -> createFormBuilder($entreprise)
                                        -> add('nom')
                                        -> add('adresse')
                                        -> add('activite')
                                        -> add('siteWeb', UrlType::class)
                                        -> add('Enregistrer', SubmitType::class)
                                        -> getForm();

        $vueFormulaireEntreprise = $formulaireEntreprise -> createView();

        $formulaireEntreprise->handleRequest($requeteHttp);

        return $this->render('accueil/formulaireEntreprise.html.twig',
                            ['vueFormulaireEntreprise'=> $vueFormulaireEntreprise]);
    }


}