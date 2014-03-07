<?php
require('ustream-api-client.class.php');

try{
        
    $ustream_inst = new UstreamApiClient();
    $ustream_inst->export_files();
    
} catch(Exception $e){
    
    echo "Erro code {$e->getCode()}: {$e->getMessage()}";
    
}
