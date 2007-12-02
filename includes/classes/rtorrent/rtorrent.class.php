<?php

class rTorrent extends Getter
{
    protected function duration($secs) 
    { 
        $vals = array(
            'w' => (int) ($secs / 86400 / 7), 
            'd' => $secs / 86400 % 7, 
            'h' => $secs / 3600 % 24, 
            'm' => $secs / 60 % 60, 
            's' => $secs % 60
        ); 

        $ret = array(); 

        $added = false; 
        foreach ($vals as $k => $v) { 
            if ($v > 0 || $added) { 
                $added = true; 
                $ret[] = $v . $k; 
            } 
        } 

        return join(' ', $ret); 
    } // end duration 
} // end rTorrent
?>
