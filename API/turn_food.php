<?php

require '../Config/config.php';
require '../Controllers/turnFoodController.php';

$obj = new turnFoodController();
try{
    $input = json_decode(file_get_contents('php://input'), true);

    switch($_SERVER["REQUEST_METHOD"]){
        case 'GET':
            if(isset($_GET['description'])){
                echo $obj ->get_obvf($_GET['local']);
            }
            break;
        case 'POST':
            if(isset($_POST['picture'])){
                 if (isset($_FILES['photo'])) {
                    // Ruta donde deseas guardar la imagen
                    $imagePath = __DIR__ .'/fotos_comedor/';

                    // Generar un nombre Ãºnico para la imagen
                    $hash = hash('sha256', uniqid());
                    $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    $imageName = $hash . '.' . $extension;

                    // Mover la imagen a la ubicaciÃ³n deseada
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $imagePath . $imageName)) {
                        $input['photo'] = $imagePath . $imageName;
                    } else {
                        echo 'Error al mover la imagen.';
                        exit;
                    }
                }
                 // Acceder a los datos adicionales
                $plate = $_POST['dish'];
                $garrison = $_POST['garrison'];
                $dessert = $_POST['dessert'];
                $received = $_POST['received'];
                $picture = $_POST['picture'];
                $menu_portal = $_POST['menu_portal'];
                $photo = $input['photo'];
                $local = $_POST['local'];
                // Llamar a la funci¨®n post_turnf con los datos adicionales
                $input = [
                    'dish' => $plate,
                    'garrison' => $garrison,
                    'dessert' => $dessert,
                    'received' => $received,
                    'picture' => $picture,
                    'menu_portal' => $menu_portal,
                    'photo' => $imageName,
                    'local' => $local
                ];
                echo $obj ->post_turnf($input);
            }
            
            
            if(isset($input['description'])){
                echo $obj ->post_obvf($input);
            }
            
            if(isset($input['finish'])){
                echo $obj ->post_obvf($input);

            }
            
            if(isset($input['dateStart']) && isset($input['dateFinal']) && isset($_GET['observation'])){
                echo $obj ->get_observations($input);

            }
            if(isset($input['dateStart']) && isset($input['dateFinal']) && isset($_GET['menu'])){
                echo $obj ->get_menu($input);

            }
            
            
            if(isset($input['local']) && isset($_GET['cerrarSess'])){
                echo $obj ->post_turncf($input);

            }
            
            break;
        case 'PATCH':
            break;
    }
}catch(Exception $e){
    echo var_dump(array('error server' => $e ));
}