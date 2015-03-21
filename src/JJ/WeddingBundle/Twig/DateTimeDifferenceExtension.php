<?php
// JJ/WeddingBundle/Twig/DateTimeDifferenceExtension.php
namespace JJ\WeddingBundle\Twig;

use Twig_Extension;

class DateTimeDifferenceExtension extends Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('diff', array($this, 'dateTimeDifferenceFunction')),
        );
    }

    public function dateTimeDifferenceFunction($dt1, $dt2, $format = null)
    {
        $dt1 = new \DateTime($dt1);
        $dt2 = new \DateTime($dt2);

        $interval = $dt2->diff($dt1);

        if(empty($format)){
            return $interval->format('%Y-%M-%D %H:%I:%S %R');
        }
        else{
            return $interval->format($format);
        }
    }

    public function getName()
    {
        return 'datetimedifference_extension';
    }
}