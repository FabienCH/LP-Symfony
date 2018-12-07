<?php
namespace mi06\VitrineBundle\Repository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LigneCommandeRepository
 *
 * @author Fabien
 */
class LigneCommandeRepository extends \Doctrine\ORM\EntityRepository {
    //put your code here
    public function topArticlesQuantite(int $max) {
        /*
        $query = $em->createQuery(
        'SELECT lc FROM mi06VitrineBundle:LigneCommande lc JOIN lc.article a GROUP BY a.id ORDER BY lc.quantite DESC');
        $query->setMaxResults($max);
        
        $query = $this->createQueryBuilder("lc")
            ->join("lc.article", "a")
            ->groupBy("a.id")
            ->orderBy("lc.quantite", "DESC")
            ->setMaxResults($max)
            ->getQuery();
        return $query->getResult();*/
        
        $query = $this->createQueryBuilder("lc")
            ->select('IDENTITY(lc.article) as articleId', 'SUM(lc.quantite) AS quantiteTotale')
            ->join("lc.article", "a")
            ->groupBy("lc.article")
            ->orderBy("quantiteTotale", "DESC")
            ->setMaxResults($max)
            ->getQuery();
         dump($query->getSQL());
        return $query->getResult();
      
        
    }
}
