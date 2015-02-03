<?php
namespace HB\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HB\BlogBundle\Entity\Article;
use HB\BlogBundle\Form\ArticleType;
/**
* Controleur de l'entit� Article
*
* @author humanbooster
*
* @Route("/article")
*/
class ArticleController extends Controller
{
/**
* Liste tous les articles
*
* @Route("/")
* @Template()
*/
public function indexAction()
{
// on r�cup�re le repository de l'Article
$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");
// on demande au repository tous les articles
$articles = $repository->findAll();
// on transmet la liste � la vue
return array('articles' => $articles);
}
/**
* Affiche un formulaire pour ajouter un article
*
* @Route("/add")
* @Template()
*/
public function addAction()
{
$article = new Article();
// on cr�� un objet formulaire en lui pr�cisant quel Type utiliser
$form = $this->createForm(new ArticleType, $article);
// On r�cup�re la requ�te
$request = $this->get('request');
// On v�rifie qu'elle est de type POST pour voir si un formulaire a �t� soumis
if ($request->getMethod() == 'POST') {
// On fait le lien Requ�te <-> Formulaire
// � partir de maintenant, la variable $article contient les valeurs entr�es dans
// le formulaire par le visiteur
$form->bind($request);
// On v�rifie que les valeurs entr�es sont correctes
// (Nous verrons la validation des objets en d�tail dans le prochain chapitre)
if ($form->isValid()) {
// On l'enregistre notre objet $article dans la base de donn�es
$em = $this->getDoctrine()->getManager();
$em->persist($article);
$em->flush();
// On redirige vers la page de visualisation de l'article nouvellement cr��
return $this->redirect(
$this->generateUrl('article_read', array('id' => $article->getId()))
);
}
}
// passe la vue de formulaire � la vue
return array( 'formulaire' => $form->createView() );
}
/**
* Affiche un article sur un Id
*
* @Route("/{id}", name="article_read")
* @Template()
*/
public function readAction($id)
{
// on r�cup�re le repository de l'Article
$repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");
// on demande au repository l'article par l'id
$article = $repository->find($id);
// on transmet notre article � la vue
return array('article' => $article);
}
/**
* Affiche un formulaire pour �diter un article sur un Id
*
* @Route("/{id}/edit")
* @Template()
*/
public function editAction($id)
{
return array();
}
/**
* Supprime un article sur un Id
*
* @Route("/{id}/delete")
* @Template()
*/
public function deleteAction($id)
{
return array();
}
}