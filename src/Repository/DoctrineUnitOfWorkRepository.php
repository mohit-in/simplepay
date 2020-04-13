<?php


namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

/**
 * Class DoctrineUnitOfWorkRepository
 * @package App\Repository
 */
class DoctrineUnitOfWorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entity = '')
    {
        parent::__construct($registry, $entity);
    }

    /**
     * Function to save entity
     *
     * @param $entity
     * @param $flush
     *
     * @throws ORMException
     */
    public function save($entity, $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->commit();
        }
    }

    /**
     * Function to remove entity
     *
     * @param $entity
     * @param $flush
     *
     * @throws ORMException
     */
    public function remove($entity, $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->commit();
        }
    }

    /**
     * Function to commit Unit of Work
     *
     * @throws ORMException
     */
    public function commit(): void
    {
        $this->getEntityManager()->flush();
    }




    public function getFullSQL($query): string
    {
        $sql = $query->getSql();
        $paramsList = $this->getListParamsByDql($query->getDql());
        $paramsArr =$this->getParamsArray($query->getParameters());
        $fullSql='';
        for($i=0, $iMax = strlen($sql); $i< $iMax; $i++){
            if($sql[$i] === '?'){
                $nameParam=array_shift($paramsList);

                if(is_string ($paramsArr[$nameParam])){
                    $fullSql.= '"'.addslashes($paramsArr[$nameParam]).'"';
                }
                elseif(is_array($paramsArr[$nameParam])){
                    $sqlArr='';
                    foreach ($paramsArr[$nameParam] as $var){
                        if(!empty($sqlArr))
                            $sqlArr.=',';

                        if(is_string($var)){
                            $sqlArr.='"'.addslashes($var).'"';
                        }else
                            $sqlArr.=$var;
                    }
                    $fullSql.=$sqlArr;
                }elseif(is_object($paramsArr[$nameParam])){
                    switch(get_class($paramsArr[$nameParam])){
                        case 'DateTime':
                            $fullSql.= "'".$paramsArr[$nameParam]->format('Y-m-d H:i:s')."'";
                            break;
                        default:
                            $fullSql.= $paramsArr[$nameParam]->getId();
                    }

                }
                else
                    $fullSql.= $paramsArr[$nameParam];

            }  else {
                $fullSql.=$sql[$i];
            }
        }
        return $fullSql;
    }
    protected function getParamsArray($paramObj): array
    {
        $parameters=array();
        foreach ($paramObj as $val){
            /* @var $val Doctrine\ORM\Query\Parameter */
            $parameters[$val->getName()]=$val->getValue();
        }

        return $parameters;
    }
    public function getListParamsByDql($dql): array
    {
        $parsedDql = preg_split("/:/", $dql);
        $length = count($parsedDql);
        $parmeters = array();
        for($i=1;$i<$length;$i++){
            if(ctype_alpha($parsedDql[$i][0])){
                $param = (preg_split("/[' ' )]/", $parsedDql[$i]));
                $parmeters[] = $param[0];
            }
        }

        return $parmeters;
    }

}
