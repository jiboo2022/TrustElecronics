<?php 
function n_digit_random() {
  $temp = "";
  $digits = 4;
  for ($i = 0; $i < $digits; $i++) {
    $temp .= rand(1, 9);
  }

  return (int)$temp;
}


?>