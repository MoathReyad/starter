<?php


namespace App\Traits;


Trait offersTrait{


     function saveImages($photo,$folder){
        // Chose and  Uploade photo
        $file_extension = $photo->getClientOriginalExtension(); // get the extension photo
        $file_name = time().'.'.$file_extension; // Chose name to photo
        $path = $folder; // Path the file in which the image will be stored
        $photo->move($path,$file_name); // insert the photo to file
        return $file_name;
    }
}
