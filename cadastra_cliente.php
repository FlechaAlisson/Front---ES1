<?php 
use GuzzleHttp\Client;
    $clienteDados = array(  'nome' => $_POST["nome"],
                            'cpf'=> $_POST["cpf"],
                            'email'=> $_POST["email"],
                            'complemento' => $_POST["complemento"],
                            'end_num' => $_POST["numero"],
                            'id' => 1,
                            'endereco'=> array(
                                'id' => 1,
                                'cidade' => array(
                                    'siglaCidade'=> null,
                                    'id' => 1,
                                    'nome' => $_POST["cidade"],
                                    'uf' => array(
                                            'nome'=> null,
                                            'ufsigla'=> $_POST["uf"]
                                    ),
                                ),
                                'bairro' => array(
                                    'id' => 1,
                                    'nome' => $_POST["bairro"],
                                ),
                                'rua' => array(
                                    'id' => 1,
                                    'nome' => $_POST["rua"],
                                ),
                                'cep' => $_POST["cep"],
                            ),
                            'telCliente' => array(
                                'telefone' => $_POST["telefone"],
                                'id' => 1,
                                'ddd' =>$_POST["ddd"]
                            ),


            );
    $clienteJson = json_encode($clienteDados);

    if (json_last_error() == 0) {
        $url = 'localhost:8080/cliente';
        $ch = curl_init($url);
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$clienteJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);    

        if ($response == "CREATED") { 
            echo "<script>alert('Cliente cadastro com sucesso');window.location='index.php'</script>";
         } else { 
             echo "<<script>alert('Cliente cadastro com sucesso');window.location='index.php'</script>";

          }

     //   echo "Cliente Cadastrado";

    }else {
        switch (json_last_error()) {
            case JSON_ERROR_SYNTAX:
                 echo 'Json mal formado';
            break;
            
            default:
                echo 'Erro desconhecido';
            break;
        }
    }

    
?>

<html lang="pt-br">
	<head>
    <title>Cadastro de cliente</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    </head>

    <body>
        <div class="container-contact100">
            <div class="wrap-contact100">
                <span class="contact100-form-title">
					Cliente cadastrado.
				</span>
        </div>
        <div class="container-contact100">
            <div class="wrap-contact100">
                <span class="contact100-form-title">
					Erro no cadastro
				</span>
        </div>

            <div class="container-contact100-form-btn">
					<button class="contact100-form-btn">
						<span>
							<i aria-hidden="true"></i>
							voltar
						</span>
					</button>
		    </div>
        
        </div>



		
		</form>
    </body>
<html>