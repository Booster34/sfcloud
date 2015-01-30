<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * controller de l entite Article
 * 
 * @author HumanBooster
 *@Route ("/article")
 */

class ArticleController extends Controller
{
    /**
     * liste ts les article du site
     * 
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
     /**
     * affiche un un formulaire pour ajouter article
     *
     * @Route ("/add")
     * @Template()
     */
    
    public function addAction()
    {
    	return array();
    
   }
    /**
     * affiche un article specidfique sur un id
     * 
     * @Route ("/{id}")
     * @Template()
     */
    
    public function readAction($id)
    {
    	//on recupere le repository d l article
    	$repository = $this->getDoctrine()->getRepository("HHBlogBundle:article");
    	
    	//on demande au repo de l article par l id
    	$article=$repository->find($id);
    	
    	//on transmet notre articlea la vue
    	return array('id'=>$id);
    
    }
    
   
   
   /**
    * edite un un formulaire pour modifier article
    *
    * @Route ("/{id}/edit")
    * @Template()
    */
   
   public function editAction($id)
   {
   	return array();
   
      }
   
      /**
       *   un formulaire pour supprimer article
       *
       * @Route ("/{id}delete")
       * @Template()
       */
       
      public function deleteAction($id)
      {
      	return array();
      	 
      }
       
}
