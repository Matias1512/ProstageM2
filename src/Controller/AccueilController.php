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

use Doctrine\ORM\EntityManagerInterface;

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
    public function ajouterEntreprise(Request $requeteHttp, EntityManagerInterface $manager){
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this   -> createFormBuilder($entreprise)
                                        -> add('nom')
                                        -> add('adresse')
                                        -> add('activite')
                                        -> add('siteWeb', UrlType::class)
                                        -> add('Enregistrer', SubmitType::class)
                                        -> getForm();

        
        $formulaireEntreprise->handleRequest($requeteHttp);

        if ($formulaireEntreprise->isSubmitted()&&$formulaireEntreprise->isValid())
        {
            //$entreprise->setDateAjout(new \DateTime());

            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('entreprises');
        }

        $vueFormulaireEntreprise = $formulaireEntreprise -> createView();

        return $this->render('accueil/formulaireEntreprise.html.twig',
                            ['vueFormulaireEntreprise'=> $vueFormulaireEntreprise]);
    }

    /**
     * @Route("/formulaireModifierEntreprise/{id_entreprise}", name="formulaireModifierEntreprise")
     */

    public function modifierEntreprise(Request $requeteHttp, EntityManagerInterface $manager, Entreprise $id_entreprise){
        
        $formulaireModifierEntreprise = $this   -> createFormBuilder($id_entreprise)
                                        -> add('nom')
                                        -> add('adresse')
                                        -> add('activite')
                                        -> add('siteWeb', UrlType::class)
                                        -> add('Enregistrer', SubmitType::class)
                                        -> getForm();

        $vueFormulaireModifierEntreprise = $formulaireModifierEntreprise -> createView();

        $formulaireModifierEntreprise->handleRequest($requeteHttp);

        if ($formulaireModifierEntreprise->isSubmitted()&&$formulaireEntreprise->isValid())
        {
            $manager->persist($id_entreprise);
            $manager->flush();
            return $this->redirectToRoute('entreprises');
        }

        return $this->render('accueil/formulaireModifierEntreprise.html.twig',
                            ['vueFormulaireModifierEntreprise'=> $vueFormulaireModifierEntreprise]);
    }

    /**
     * @Route("/Stage/ajouter", name="ajoutStage")
     */
    public function ajouterStage(Request $requeteHttp, ObjectManager $manager)
    {
        $stage=new Stage();
        $formulaireStage=$this->createForm(StageType::class, $stage);
        $formulaireStage->handleRequest($requeteHttp);
    }

}