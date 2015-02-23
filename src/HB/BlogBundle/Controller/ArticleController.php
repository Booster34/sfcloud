<?php
namespace HB\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HB\BlogBundle\Entity\Article;
use HB\BlogBundle\Form\ArticleType;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
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
* @Route("/", name="article_list")
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
* @Route("/add", name="article_add")
* @Template()
*/
public function addAction()
{
$article = new Article;
return $this->editAction($article);
}
/**
* Affiche un article sur un Id
*
* @Route("/{id}", name="article_read")
* @Template()
*/
public function readAction(Article $article)
{
// on a r�cup�r� l'article grace � un ParamConverter magique
// on transmet notre article � la vue
return array('article' => $article);
}
/**
* Affiche un formulaire pour �diter un article sur un Id
*
* @Route("/{id}/edit", name="article_edit")
* @Route("/titre/{titre}/edit")
* @Template("HBBlogBundle:Article:add.html.twig")
*/
public function editAction(Article $article)
{
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
if ($article->getId()>0)
$edition = true;
else
$edition = false;
// passe la vue de formulaire � la vue
return array( 'formulaire' => $form->createView(), 'edition' => $edition );
}
/**
* Supprime un article sur un Id
*
* @Route("/{id}/delete", name="article_delete")
*/
public function deleteAction(Article $article)
{
// on a r�cup�r� l'article grace � un ParamConverter magique
// on demande � l'entity manager de supprimer l'article
$em = $this->getDoctrine()->getEntityManager();
$em->remove($article);
$em->flush();
// On redirige vers la page de liste des articles
return $this->redirect(
$this->generateUrl('article_list')
);
}
/**
* Affiche l'auteur d'un article
*
* @param Article $article
*
* @Route("/{id}/auteur", name="article_auteur")
*/
public function readAuteurAction(Article $article) {
if ($article->getAuteur()!=null) {
return $this->redirect(
$this->generateUrl('utilisateur_read', array('id' => $article->getAuteur()->getId()))
);
} else {
throw new NotFoundResourceException("Auteur invalide.");
}
}
}
