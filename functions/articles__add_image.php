<?php
    function can_upload($file){
        
        if($file['size'] == 0)
            return 'Размер файла слишком большой для добавления к новости';

        $getMime = explode('.', $file['name']);

        $mime = strtolower(end($getMime));
        $types = array('jpg', 'png', 'jpeg');

        if(!in_array($mime, $types))
            return 'Недопустимый тип файла';
        
        return true;
    }
    $rnd = mt_rand(0, 10000);
    function make_upload($file){
        $name = $rnd . $file['name'];
        copy($file['tmp_name'], "../static/images/". $name);
    }
?>