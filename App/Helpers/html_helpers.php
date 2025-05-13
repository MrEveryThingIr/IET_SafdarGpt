<?php

function modal($content,$modal_id='the_modal',$more_options=[]){
    echo "  
         <div id=\"$modal_id\" 
             class=\"fixed inset-0 z-50 hidden bg-black bg-opacity-50\">
          <div class=\"modal-content absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg w-full max-w-md\">
            <button class=\"close absolute top-2 right-2 text-2xl\">&times;</button>
            $content
          </div>
        </div>";
}