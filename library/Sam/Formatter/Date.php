<?php
/**
 * Description of Date
 *
 * @author alex
 */
class Sam_Formatter_Date 
{
    public static function TimeToFullDate($timestamp)
    {
        $formattedDate = date('d/m/Y', $timestamp);
        return $formattedDate;
    }
    
    public static function TimeToDateAndTime($timestamp)
    {
        $date = new DateTime($timestamp);
        $formattedDateAndTime = $date->format('d/m/Y H:i:s');
        return $formattedDate;
    }
    
    public function DateAndTimeToDate($data) 
    {
        if ($data instanceof DateTime)
        {
            return $data->format("d/m/Y");
        }
        if (!empty($data)) 
        {
            return date('d/m/Y', strtotime($data));
        }
        return "";
    }

    public static function dateToTimestamp($data){
        if ( empty($data))
            return null;
        if ( $data instanceof DateTime )
            return $data->getTimestamp();
        //echo "Date ".$data; die();
        return strtotime($data);
    }
    
    public static function dateXml($data) {
        if ($data == "")
            return null;
        else {
            $date = DateTime::createFromFormat('dmY', $data);
            return $date->format('d/m/Y');
        }
    }
}
