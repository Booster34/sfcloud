<?php
namespace HB\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HB\BlogBundle\Entity\Utilisateur;
use HB\BlogBundle\Form\UtilisateurType;
/**
* Controleur de l'entité Utilisateur
*
* @author humanbooster
*
* @Route("/Utilisateur")
*/
class UtilisateurController extends Controller
{
/**
* Liste tous les Utilisateurs
*
* @Route("/")
* @Template()
*/
public function indexAction()
{
// on récupère le repository de l'Utilisateur
$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Utilisateur");
// on demande au repository tous les Utilisateurs
$Utilisateur = $repository->findAll();
// on transmet la liste à la vue
return array('Utilisateur' => $Utilisateur);
}
/**
* Affiche un formulaire pour ajouter un Utilisateur
*
* @Route("/add")
* @Template()
*/
public function addAction()
{
$Utilisateur = new Utilisateur();
// on créé un objet formulaire en lui précisant quel Type utiliser
$form = $this->createForm(new UtilisateurType, $Utilisateur);
// On récupère la requête
$request = $this->get('request');
// On vérifie qu'elle est de type POST pour voir si un formulaire a été soumis
if ($request->getMethod() == 'POST') {
// On fait le lien Requête <-> Formulaire
// À partir de maintenant, la variable $Utilisateur contient les valeurs entrées dans
// le formulaire par le visiteur
$form->bind($request);
// On vérifie que les valeurs entrées sont correctes
// (Nous verrons la validation des objets en détail dans le prochain chapitre)
if ($form->isValid()) {
// On l'enregistre notre objet $Utilisateur dans la base de données
$em = $this->getDoctrine()->getManager();
$em->persist($Utilisateur);
$em->flush();
// On redirige vers la page de visualisation de l'Utilisateur nouvellement créé
return $this->redirect(
$this->generateUrl('Utilisateur_read', array('id' => $Utilisateur->getId()))
);
}
}
// passe la vue de formulaire à la vue
return array( 'formulaire' => $form->createView() );
}
/**
* Affiche un Utilisateur sur un Id
*
* @Route("/{id}", name="Utilisateur_read")
* @Template()
*/
public function readAction($id)
{
// on récupère le repository de l'Utilisateur
$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Utilisateur");
// on demande au repository l'Utilisateur par l'id
$Utilisateur = $repository->find($id);
// on transmet notre Utilisateur à la vue
return array('Utilisateur' => $Utilisateur);
}
/**
* Affiche un formulaire pour éditer un Utilisateur sur un Id
*
* @Route("/{id}/edit")
* @Template()
*/
public function editAction($id)
{
return array();
}
/**
* Supprime un Utilisateur sur un Id
*
* @Route("/{id}/delete")
* @Template()
*/
public function deleteAction($id)
{
return array();
}
}