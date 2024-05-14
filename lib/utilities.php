<?php

namespace Lib;
class Utility
{
    
    static public function generate_id(){
        $results = "";
        $code = "dxfDaVAnVDuaeZy3A5xjcKlmmuL9l7Fb2fa5FWO+vYw9mFLSYST6aJD2bKNY6VqI";

        $index = 1;
        while ($index <= 15) {
            # code...
            $results .= $code[rand(0, 52)];

            $index++;
        }

        return $results;
        
    }
}
