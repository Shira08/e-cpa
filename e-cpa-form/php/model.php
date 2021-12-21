<?php
$bdd = new PDO ("mysql:host=localhost;dbname=e-cpa;charset=utf8",'root', '');
var_dump($_POST);
if(isset($_POST['submit']))
{
    
    $name= htmlspecialchars($_POST['name']);
    $surname= htmlspecialchars($_POST['surname']);
    $contact= htmlspecialchars($_POST['contact']);
    $city= htmlspecialchars($_POST['city']);
    
    if(!empty($name) && !empty($surname) && !empty($contact) && !empty($city) && !empty($profil_picture))
    {
        if(strlen($name) < 255 && strlen($surname) < 255 && strlen($name) != 1 && strlen($surname) != 1)
        {
            if(is_integer($contact))
            {
                $uploadDirectory = "/Admin/Images/";
                $file_name = $_FILES['file']['name'];
                $file_extension =  strrchr($file_name,".");
                $validExtensions = array('jpg', 'jpeg', 'png', 'bmp');
                $file_tmp_name = $_FILES['fichier']['tmp_name'];
                $img_ref = rand();
                $sqlValues = "";

                $file_dest = $uploadDirectory.$file_name;
                if(in_array($file_extension, $validExtensions))
                {
                    if(move_uploaded_file($file_tmp_name,$file_dest))
                    {
                       
                       /* foreach ($_FILES['image']['tmp_name'] as $imageKey => $imageValue) {

                            $image = $_FILES['files']['name'][$imageKey];
                            $imageSize = $_FILES['files']['size'][$imageKey];
                            $imageTmp = $_FILES['files']['tmp_name'][$imageKey];
                            $imageType = pathinfo($uploadDirectory.$image, PATHINFO_EXTENSION);
                    
                            // Get Image New Name
                            if ($image !== '') {
                    
                                $imageNewName = uniqid().".".$imageType;
                            }
                            else{
                                $imageNewName = "";
                                $errorImage .= "<span style='color:red;'>Image Required...!</span>";
                            }
                    
                            if ($imageSize > 1024000) {
                                
                                $errorSize .= "<span style='color:red;'>Larg Image Size must be under 1 Mb...!</span>";
                            }
                            else if (!empty($image) && !in_array($imageType, $validExtensions)) {
                                
                                $errorType .= "<span style='color:red;'>File must be an Image...!</span>";
                            }
                            else if (empty($message)) {
                                
                                $sqlValues .= "('".$imageNewName."', '".$img_ref."'),";
                    
                                $store = move_uploaded_file($imageTmp, $uploadDirectory.$imageNewName); 
                            }	*/
                    }
                    else
                    {
                        $message = "Erreur d'envoie de l'image  ..!";
                    }
                }
                else
                {
                    $message = "La photo de profil doit être une image  ..!";
                }
            }
            else
            {
                $message = "Veuillez entrer un numéro valide ..!";
            }

        }
        else
        {
            $message = "Le nom, prénom(s) doivent être moins de 255 caractères ..!";
        }
    }
    else
    {
       $message = "Veuillez remplir tout les champs ...!" ;
    }
}
