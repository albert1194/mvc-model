<?php

  foreach($data['users'] as $user){
    echo "information: " . $user->username . $user->email ; 
    echo '<br/>';
  }
?> 