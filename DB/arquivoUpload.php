<?php

function arquivoUpload($file, $allowed_exs, $path) {
    $file_name = $file['name'];
    $tmp_name = $file['tmp_name'];
    $error = $file['error'];
    
    if ($error === 0) {
        $file_ex = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_ex_lc = strtolower($file_ex);
        
        if (in_array($file_ex_lc, $allowed_exs)) {
            // Usando o próprio nome original da imagem no upload
            $new_file_name = $file_name;
            $file_upload_path = '../uploads/' . $path . '/' . $new_file_name;
            
            if (!is_dir('../uploads/' . $path)) {
                mkdir('../uploads/' . $path, 0777, true);
            }
            
            move_uploaded_file($tmp_name, $file_upload_path);
            $sm['status'] = 'success';
            $sm['data'] = $new_file_name;
            return $sm;
        } else {
            $em['status'] = 'error';
            $em['data'] = 'Você não pode anexar o arquivo com esse formato';
            return $em;
        }
    } else {
        $em['status'] = 'error';
        $em['data'] = 'Erro no upload do arquivo';
        return $em;
    }
}
