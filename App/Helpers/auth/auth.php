<?php

function itIsMe($id){
    if(isLoggedIn()&& ($id==$_SESSION['user_id'])){
        return 1==1;
    }
}