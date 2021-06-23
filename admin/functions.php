<?php
/*
	    validaCPF - função para validar CPF
	    Como usar: 
	    $cpf = "123.123.123-34";
	    $msg = validaCPF($cpf);
	    if ( $msg != 1 ) echo $msg; //deu erro
	    retornando 1 o documento é inválido
	*/
function validaCPF($cpf)
{

	// Extrai somente os números
	$cpf = preg_replace('/[^0-9]/is', '', $cpf);

	// Verifica se foi informado todos os digitos corretamente
	if (strlen($cpf) != 11) {
		return "O CPF precisa ter ao menos 11 números";
	}
	// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
	if (preg_match('/(\d)\1{10}/', $cpf)) {
		return "CPF inválido";
	}
	// Faz o calculo para validar o CPF
	for ($t = 9; $t < 11; $t++) {
		for ($d = 0, $c = 0; $c < $t; $c++) {
			$d += $cpf{
				$c} * (($t + 1) - $c);
		}
		$d = ((10 * $d) % 11) % 10;
		if ($cpf{
			$c} != $d) {
			return "CPF inválido";
		}
	}
	return true;
}


/*
		Função para redimensionar imagens JPG
		Irá criar 3 imagens: 
		- G Largura de 800px 
		- M Largura de 640px
		- P Largura de 250px
		A altura será proporcional a altura para que a imagem não fique deslocada

		Parâmetros: arquivo da imagem (Ex.: fotos/imagem.jpg), novo nome para renomear (Ex.: 12345)
	*/

function redimensionarImagem($pastaFotos, $imagem, $nome)
{

	$imagem = $pastaFotos . $imagem;

	list($largura1, $altura1) = getimagesize($imagem);

	$largura = 800;
	$percent = ($largura / $largura1);
	$altura = $altura1 * $percent;

	$imagem_gerada = $pastaFotos . $nome . "g.jpg";
	$path = $imagem;
	$imagem_orig = ImageCreateFromJPEG($path);
	$pontoX = ImagesX($imagem_orig);
	$pontoY = ImagesY($imagem_orig);
	$imagem_fin = ImageCreateTrueColor($largura, $altura);
	ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura + 1, $altura + 1, $pontoX, $pontoY);
	ImageJPEG($imagem_fin, $imagem_gerada, 100);
	ImageDestroy($imagem_orig);
	ImageDestroy($imagem_fin);

	$largura = 640;
	$percent = ($largura / $largura1);
	$altura = $altura1 * $percent;

	$imagem_gerada = $pastaFotos . $nome . "m.jpg";
	$path = $imagem;
	$imagem_orig = ImageCreateFromJPEG($path);
	$pontoX = ImagesX($imagem_orig);
	$pontoY = ImagesY($imagem_orig);
	$imagem_fin = ImageCreateTrueColor($largura, $altura);
	ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura + 1, $altura + 1, $pontoX, $pontoY);
	ImageJPEG($imagem_fin, $imagem_gerada, 80);
	ImageDestroy($imagem_orig);
	ImageDestroy($imagem_fin);

	$largura = 250;
	$percent = ($largura / $largura1);
	$altura = $altura1 * $percent;

	$imagem_gerada = $pastaFotos . $nome . "p.jpg";
	$path = $imagem;
	$imagem_orig = ImageCreateFromJPEG($path);
	$pontoX = ImagesX($imagem_orig);
	$pontoY = ImagesY($imagem_orig);
	$imagem_fin = ImageCreateTrueColor($largura, $altura);
	ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura + 1, $altura + 1, $pontoX, $pontoY);
	ImageJPEG($imagem_fin, $imagem_gerada, 80);
	ImageDestroy($imagem_orig);
	ImageDestroy($imagem_fin);

	//apagar a imagem antiga
	unlink($imagem);
}

/**
 * Funçao para formatar a data
 * $data - data a formatar
 */
function formatar($data)
{
	// 01/12/2020 -> 2020-12-01
	$data = explode("/", $data);
	$data = $data[2] . "-" . $data[1] . "-" . $data[0];

	return $data;
}

/**
 * Funcão para retirar os underlines de $numero
 */
function retirar($numero)
{
	$numero = str_replace("_", "", $numero);

	return $numero;
}

/**
 * Função para formatar valor monetário
 * $valor
 */
function formatarValor($valor)
{
	// 12.000,00 -> 12000.00
	$valor = str_replace(".", "", $valor);
	$valor = str_replace(",", ".", $valor);

	return $valor;
}


function msg($titulo, $mensagem, $icone) { //Função que retorna um alerta bonitinho

	?>
	<script>
		//mostrar a telinha animada - alert
		Swal.fire(
		  '<?=$titulo?>',
		  '<?=$mensagem?>',
		  '<?=$icone?>'
		).then((result) => {
			//retornar para a tela anterior
			history.back();
		})
	</script>
	<?php

	exit;

}

	