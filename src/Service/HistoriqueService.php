<?Php
nameSpace App\Service;

use App\Entity\Historique;
use App\Repository\HistoriqueRepository;

Class HistoriqueService
{
    private $ripo;
    public function __construct(HistoriqueRepository $ripo)
    {
        $this->ripo = $ripo;
    }
    public function misyAmmendeVe(Historique $historique): bool
    {
        // enquete si l'historique avait ete ammende
       
        if(date_diff($historique->getDepart(),$historique->getTarif()->getTemps() )->invert==1)
        {
            return true;
        }
        return false;
    }
    public function chercherHistoriqueMatricule(String $matricule){
         $isany= $this->ripo->findCount($matricule);
         $listeHistorique =   $this->ripo->findBy(['matricule'=> $matricule]);
         if($listeHistorique !== null){
            
            if($isany>=2){
                return true;
            }
           /*  dd(false);
            foreach($listeHistorique as $historique){
                
                if($this->misyAmmendeVe($historique)){
                    return true;
                }
            } */
            return false;
         }
         return false;
    }
      public function getEtatHistorique(Historique $historique){
        if($this->histoServe->misyAmmendeVe($historique) ){
            return $this->ammendeServe->ammende;
        }
        return 0;
    }
}

?>
