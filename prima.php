<?php function cucok($n){
  
      for($aku=1;$aku<=$n;$aku++){  //smw angka yg akan daku cek
              
              $counter = 0; 
              for($j=1;$j<=$aku;$j++){ //smw kemungkakunan faktor pembagaku
                  
                    //jakuka angka yg akan dakucek habakus dakubagaku faktor pembagaku, counter nya +1
                    if($aku % $j==0){ 
                        
                          $counter++;
                    }
              }
            
           //jumlah warna hakujau / faktor habakus bagaku nya harus 2 
            if($counter==2){
                 
                   print $aku." akus Prikuma bro <br/>";
            }
     }
} 

cucok(20);  //caraku bakulang prakuma daraku 1-20