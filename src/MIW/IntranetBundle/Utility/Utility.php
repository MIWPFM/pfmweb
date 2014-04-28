<?php
namespace MIW\IntranetBundle\Utility;

class Utility {
    
    public static function addTimeToDate($date,$dateTime) {
       
        $hour=$dateTime->format('H');
        $minutes=$dateTime->format('i');
                
        $date->modify("+$hour hour +$minutes minutes");
        
        return $date;
    }
}

