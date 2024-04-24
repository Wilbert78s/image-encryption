<?php

namespace App\Services;
    
class ValidateInput {
    public static function checkPrime($target): bool 
    {
        if ($target <= 1) {
            return false; // 0 and 1 are not prime numbers
        }
        // $test = 0;
        $squareRoot = ceil(sqrt($target));
        // echo($squareRoot);
        $check = array_fill(1, $squareRoot, false);
        for($i=2; $i<=  $squareRoot; $i++) {
            if ($check[$i]) continue;
            // echo("$i\n");
            // $test++;
            if($target % $i == 0) {
                return false;
            }

            $j = $i;
            do {
                $check[$j] = true;
                $j += $i;
            } while ($j < $squareRoot);
        }
        // echo "\n$squareRoot\n";
        // echo "$test\n";
        // can check up to 10^13
        return true;
    }
}