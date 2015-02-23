<?php
namespace HB\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HB\BlogBundle\Entity\Utilisateur;
use HB\BlogBundle\Form\UtilisateurType;
/**
* Controleur de l'entit� Utilisateur
*
* @author humanbooster
*
* @Route("/utilisateur")
*/
class UtilisateurController extends Controller
{
/**
* Liste tous les utilisateurs
*
* @Route("/", name="utilisateur_list")
* @Template()
*/
public function indexAction()
{
// on r�cup�re le repository de l'Utilisateur
$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Utilisateur");
// on demande au repository tous les utilisateurs
$utilisateurs = $repository->findAll();
// on transmet la liste � la vue
return array('utilisateurs' => $utilisateurs);
}
/**
* Affiche un formulaire pour ajouter un utilisateur
*
* @Route("/add", name="utilisateur_add")
* @Template()
*/
public function addAction()
{
$utilisateur = new Utilisateur;
return $this->editAction($utilisateur);
}
/**
* Affiche un utilisateur sur un Id
*
* @Route("/{id}", name="utilisateur_read")
* @Template()
*/
public function readAction(Utilisateur $utilisateur)
{
// on a r�cup�r� l'utilisateur grace � un ParamConverter magique
// on transmet notre utilisateur � la vue
return array('utilisateur' => $utilisateur);
}
/**
* Affiche un formulaire pour �diter un utilisateur sur un Id
*
* @Route("/{id}/edit", name="utilisateur_edit")
* @Route("/titre/{titre}/edit")
* @Template("HBBlogBundle:Utilisateur:add.html.twig")
*/
public function editAction(Utilisateur $utilisateur)
{
// on cr�� un objet formulaire en lui pr�cisant quel Type utiliser
$form = $this->createForm(new UtilisateurType, $utilisateur);
// On r�cup�re la requ�te
$request = $this->get('request');
// On v�rifie qu'elle est de type POST pour voir si un formulaire a �t� soumis
if ($request->getMethod() == 'POST') {
// On fait le lien Requ�te <-> Formulaire
// � partir de maintenant, la variable $utilisateur contient les valeurs entr�es dans
// le formulaire par le visiteur
$form->bind($request);
// On v�rifie que les valeurs entr�es sont correctes
// (Nous verrons la validation des objets en d�tail dans le prochain chapitre)
if ($form->isValid()) {
// On l'enregistre notre objet $utilisateur dans la base de donn�es
$em = $this->getDoctrine()->getManager();
$em->persist($utilisateur);
$em->flush();
// On redirige vers la page de visualisation de l'utilisateur nouvellement cr��
return $this->redirect(
$this->generateUrl('utilisateur_read', array('id' => $utilisateur->getId()))
);
}
}
if ($utilisateur->getId()>0)
$edition = true;
else
$edition = false;
// passe la vue de formulaire � la vue
return array( 'formulaire' => $form->createView(), 'edition' => $edition );
}
/**
* Supprime un utilisateur sur un Id
*
* @Route("/{id}/delete", name="utilisateur_delete")
*/
public function deleteAction(Utilisateur $utilisateur)
{
// on a r�cup�r� l'utilisateur grace � un ParamConverter magique
// on demande � l'entity manager de supprimer l'utilisateur
$em = $this->getDoctrine()->getEntityManager();
$em->remove($utilisateur);
$em->flush();
// On redirige vers la page de liste des utilisateurs
return $this->redirect(
$this->generateUrl('utilisateur_list')
);
}
/**
* Liste les articles d'un utilisateur
*
* @Route("/{id}/articles", name="utilisateur_articles")
* @Template()
*
*/
public function listArticlesAction(Utilisateur $utilisateur)
{
return array('utilisateur' => $utilisateur,
'articles' => $utilisateur->getArticles()
);
}
}