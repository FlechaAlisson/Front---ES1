<!DOCTYPE html>
<html lang="pt_br">
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

<?php	use GuzzleHttp\Client;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
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
				echo "<script>alert('Cliente cadastro com sucesso');window.location='menu.php'</script>";
				header("Location: localhost/menu.php");
			} else { 
				echo "<<script>alert('Erro no cadastro do cliente');</script>";
				$var = "<script>javascript:history.back(-2)</script>";
				echo $var;

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

	}
?>

<script>
	$(document).ready(function endereco() {

	function limpa_formulário_cep() {
		// Limpa valores do formulário de cep.
		$("#rua").val("");
		$("#bairro").val("");
		$("#cidade").val("");
		$("#uf").val("");
		$("#ibge").val("");
	}

	//Quando o campo cep perde o foco.
	$("#cep").blur(function() {

		//Nova variável "cep" somente com dígitos.
		var cep = $(this).val().replace(/\D/g, '');

		//Verifica se campo cep possui valor informado.
		if (cep != "") {

			//Expressão regular para validar o CEP.
			var validacep = /^[0-9]{8}$/;

			//Valida o formato do CEP.
			if(validacep.test(cep)) {

				//Preenche os campos com "..." enquanto consulta webservice.
				$("#rua").val("...");
				$("#bairro").val("...");
				$("#cidade").val("...");
				$("#uf").val("...");
				$("#ibge").val("...");

				//Consulta o webservice viacep.com.br/
				$.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

					if (!("erro" in dados)) {
						//Atualiza os campos com os valores da consulta.
						$("#rua").val(dados.logradouro);
						$("#bairro").val(dados.bairro);
						$("#cidade").val(dados.localidade);
						$("#uf").val(dados.uf);
						$("#ibge").val(dados.ibge);
					} //end if.
					else {
						//CEP pesquisado não foi encontrado.
						limpa_formulário_cep();
						alert("CEP não encontrado.");
					}
				});
			} //end if.
			else {
				//cep é inválido.
				limpa_formulário_cep();
				alert("Formato de CEP inválido.");
			}
		} //end if.
		else {
			//cep sem valor, limpa formulário.
			limpa_formulário_cep();
		}
	});
	});
	</script>



	<!--===============================================================================================-->
</head>

<body>

<form method="POST" action="#">
	<div class="container-contact100">

		<div class="wrap-contact100">
			<form class="contact100-form validate-form">
				<span class="contact100-form-title">
					Cadastro de cliente
				</span>

				<div class="wrap-input100 validate-input" data-validate="Entre com o seu nome">
					<input class="input100" type="text" name="nome" placeholder="Nome completo">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Entre com um e-mail: e@a.x">
					<input class="input100" type="text" name="email" placeholder="E-mail">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Entre com o seu CPF">
					<input class="input100" type="text" name="cpf" placeholder="CPF">
					<span class="focus-input100"></span>
				</div>
				
				<div class="wrap-input99 validate-input" data-validate = "Entre com o seu DDD">
					<input class="input100" type="text" name="ddd" maxlength="2" placeholder="DDD">
					<span class="focus-input100"></span>
				</div>
				
				<div class="wrap-input98 validate-input" data-validate = "Entre com o seu telefone">
					<input class="input100" type="text" name="telefone" maxlength="9" placeholder="Telefone">
					<span class="focus-input100"></span>
				</div>
				
				<span class="contact99-form-title">
					Dados do endereço
				
				</span>
				
				<div class="wrap-input100 validate-input" data-validate = "Entre com o seu CEP">
					<input class="input100" id="cep" for= "cep" type="text" pattern="-?[0-9]*(\.[0-9]+)?"
					  maxlength="9" name="cep" placeholder="CEP">
					<span class="focus-input100"></span>
				</div>
				
				<div class="wrap-input100 validate-input" data-validate = "Entre com o seu cidade">
					<input class="input100" for="cidade" id="cidade"type="text" name="cidade" placeholder="Cidade">
					<span class="focus-input100"></span>
				</div>
				
				<div class="wrap-input100 validate-input" data-validate = "Entre com o seu rua">
					<input class="input100" type="text" name="rua" id="rua" placeholder="Rua">
					<span class="focus-input100"></span>
				</div>

				
				<div class="wrap-input100 validate-input" data-validate = "Entre com o seu bairro">
					<input class="input100" for="bairro" id="bairro"type="text" name="bairro" placeholder="Bairro">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Entre com o seu UF">
					<input class="input100" id="uf" type="text" name="uf" placeholder="UF">
					<span class="focus-input100"></span>
				</div>	

				<div class="wrap-input100 validate-input" data-validate = "Entre com o seu complemento">
					<input class="input100" id="complemento" type="text" name="complemento" placeholder="Complemento">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Entre com o seu número">
					<input class="input100" id="numero" type="text" name="numero" placeholder="Número">
					<span class="focus-input100"></span>
				</div>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn">
						<span>
							<i aria-hidden="true"></i>
							Cadastrar
						</span>
					</button>
				</div>
			</form>
		</div>
	</div>
	</form>



	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

</body>
</html>
