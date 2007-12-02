<?php

class Settings extends rTorrent 
{
    protected $rpc_uri = '';
    
    public function __construct($rpc_uri)
    {
        $this->rpc_uri = $rpc_uri;
    } // end __construct

    private function _load()
    {

    } // end _load

} // end ClientSettings

?>
