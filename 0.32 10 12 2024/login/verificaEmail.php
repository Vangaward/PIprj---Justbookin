<?php
	require_once '../classes/Cripto.php';
?>

<html lang="pt-br">
    <head>
        <link rel="shortcut icon" href="../imgs/RCLogo2.png" />
        <?php include_once('../b.php'); ?>
		<link rel="stylesheet" href="../Styles/verificaEmail.css">
		<link rel="stylesheet" href="../Balacowork/Balacowork.css">
        <meta charset="UTF-8">
    </head>
</html>
<body>
	<main class="conteudo">
		<div class="container">
			<?php

			session_start();
			include_once('../conexao.php');
			include('../PHPMailer/email.php');
			include_once('rsl.php');

			if (!isset($_GET['i']))
			{
				erroUsuario();
			}

			$idUsuarioUrlSha1 = $_GET['i'];

			// Preparação da consulta
			$stmt = mysqli_prepare($conexao, "SELECT u.idUsuario, u.nome, u.statusConta, u.email, t.token, t.criacao, t.expiracao FROM usuario u
				INNER JOIN token t ON u.idUsuario = t.idUsuarioToken
				WHERE " . (new Cripto(""))->getTc() . "(u.idUsuario) = ?"); //HERE

			// Vincular parâmetro e executar a consulta
			mysqli_stmt_bind_param($stmt, "s", $idUsuarioUrlSha1);
			mysqli_stmt_execute($stmt);

			$dadosUsuario = mysqli_fetch_array(mysqli_stmt_get_result($stmt));

			// Fechar a declaração
			mysqli_stmt_close($stmt);

			function erroUsuario()
			{
				?>
				<center><h1 class="titulo">Houve um erro inesperado! Verifique seu link e tente novamente,</h1><br>
				<a class="linkErro" href="index.php">clique aqui para acessar a página de login</a>
				<br><br>
				<a class="linkErro" href="../index.php">clique aqui para acessar a página inicial</a>
				</div>
				</center>
				<div class="footerFixado">©<?php echo date("Y"); ?> Todos os direitos reservados à JustBookIn.</div>
				<?php
				die();
			}

			if ($dadosUsuario == null)
			{
				erroUsuario();
			}
			else
			{
				if ($dadosUsuario['statusConta'] == 1)
				{
					?>
					<center><h1 class="titulo">Sua Conta foi validada com sucesso!<br><a href="index.php">Clique aqui para fazer Login</a/></h1></center>
					<?php
					die();
				}
				else if ($dadosUsuario['statusConta'] == 0)
				{
					
					if (isset($_GET['token']))
					{
						
						if ($dadosUsuario['token'] != $_GET['token'] || (new DateTime())->format('Y-m-d H:i:s') > $dadosUsuario['expiracao'])
						{ ?>
							<center><h1 class="titulo">O Token é inválido!<br>Os e-mails são válidos por 15 minutos após serem enviados<br><a href="index.php">Faça login para reenviar o email de confirmação</a/></h1></center>
					
						<?php
							die();
						}
						else //Atualizar statusConta para 1
						{
							$statusConta = 1;
							$sqlUpdatUsuario = "UPDATE usuario SET statusConta = ? WHERE idUsuario = ?";
							$stmt = mysqli_prepare($conexao, $sqlUpdatUsuario);
							mysqli_stmt_bind_param($stmt, "ss", $statusConta, $dadosUsuario['idUsuario']);
							$resultado = mysqli_stmt_execute($stmt);
							if (!$resultado) { die("Erro ao atualizar usuário, tente novamente mais tarde. Pedimos desculpas por isso.");}
							mysqli_stmt_close($stmt);
							header("Location: verificaEmail.php?i=" . $idUsuarioUrlSha1 . "&token=" . $_GET['token']);
							die("<h1><br>   Processando...</h1>");
						}
					}
					else
					{
						//verificar se já faz mais de 1 minuto que o último email foi enviado
						// Calculando a diferença
						$intervalo = (new DateTime($dadosUsuario['criacao']))->diff(new DateTime());
						// Convertendo a diferença para segundos
						$diferencaSegundos = ($intervalo->days * 24 * 60 * 60) + ($intervalo->h * 60 * 60) + ($intervalo->i * 60) + $intervalo->s;
						$difSegsCorrigida = 60 - $diferencaSegundos;
						if ($dadosUsuario['criacao'] != null && $difSegsCorrigida > 0)
						{
							?>
							<script>alert("Por favor, aguarde <?php echo $difSegsCorrigida; ?> segundos para reenviar o E-mail");</script>
							<?php
						}
						else
						{
							$emailUsuario = $dadosUsuario['email'];
							$nomeDoUsuario = $dadosUsuario['nome'];
						
							$token =  bin2hex(random_bytes(32)); // Gera um token de 64 caracteres (32 bytes em hexadecimal)
							$sqlToken = "UPDATE token SET token=?, expiracao=?, criacao=? WHERE idUsuarioToken = ?";
							$stmt = mysqli_prepare($conexao, $sqlToken);
							mysqli_stmt_bind_param($stmt, "ssss", $token, (new DateTime())->modify('+15 minutes')->format('Y-m-d H:i:s'), (new DateTime())->format('Y-m-d H:i:s'), $dadosUsuario['idUsuario']);
							$resultado = mysqli_stmt_execute($stmt);
							if (!$resultado) { die("Erro ao gerar Token");}
							mysqli_stmt_close($stmt);
							
							$assuntoEmail = "JustBookIn - Validação de conta";
							$link = "http://justbookin.kesug.com/login/verificaEmail.php?i=" . (new Cripto($dadosUsuario['idUsuario']))->getCripto() . "&token=" . $token;
							
							try {
								$mail->isHTML(true); 
								$mail->addAddress($emailUsuario);
								$mail->Subject = 'JustBookIn, Confirmar Email';
								$mail->Body = '
								<body style="margin: 0; padding: 0;">
									<table align="center" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 1px solid black;">
										<tbody>
											<tr>
												<td align="center" bgcolor="#1c1c24" style="padding: 40px 0 30px 0;">
													<svg id="svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="300" height="230" viewBox="0, 0, 400,400" version="1.1"><g id="svgg"><path id="path0" d="M339.600 51.669 C 338.143 52.073,336.063 52.606,333.500 53.233 C 326.166 55.027,312.551 59.755,305.200 63.060 C 303.990 63.604,301.922 64.533,300.605 65.124 C 297.841 66.365,280.650 74.996,273.000 78.984 C 259.780 85.874,255.569 88.233,251.222 91.185 C 248.885 92.772,240.054 98.470,231.200 104.104 C 228.450 105.854,224.985 108.316,223.500 109.575 C 222.015 110.834,220.305 112.119,219.700 112.431 C 215.738 114.469,210.776 118.266,204.805 123.827 C 203.372 125.162,201.725 126.602,201.146 127.027 C 197.940 129.377,185.076 141.524,183.973 143.242 C 182.648 145.307,174.166 153.617,173.424 153.578 C 172.603 153.534,166.510 145.051,165.109 142.000 C 164.755 141.230,163.719 138.710,162.807 136.400 C 158.337 125.077,152.281 116.966,144.400 111.743 C 136.371 106.421,132.427 105.456,119.800 105.725 C 109.923 105.935,109.402 106.011,97.600 108.983 C 89.341 111.063,87.023 111.333,79.780 111.056 C 76.271 110.922,72.140 110.644,70.600 110.437 C 69.060 110.231,66.270 109.854,64.400 109.600 C 57.253 108.629,55.171 108.429,47.600 107.985 C 35.206 107.258,21.061 107.878,13.400 109.482 C 11.860 109.805,10.147 110.157,9.593 110.266 C 8.078 110.563,4.253 112.530,4.083 113.100 C 3.965 113.495,7.612 113.600,21.390 113.600 C 31.211 113.600,40.104 113.780,41.723 114.011 C 56.623 116.141,69.269 118.654,73.800 120.387 C 83.723 124.182,90.152 129.291,100.256 141.413 C 105.998 148.303,112.607 158.104,117.373 166.800 C 119.963 171.525,124.000 180.064,124.000 180.817 C 124.000 181.034,124.171 181.523,124.381 181.905 C 124.893 182.839,126.251 187.062,126.597 188.800 C 127.842 195.045,129.396 201.419,130.498 204.800 C 131.414 207.610,131.913 209.584,132.420 212.400 C 133.590 218.894,135.670 223.922,139.701 230.000 C 142.279 233.888,160.616 252.141,164.474 254.659 C 165.945 255.620,167.385 256.632,167.674 256.908 C 167.963 257.185,169.006 258.039,169.990 258.806 C 175.597 263.173,175.909 265.195,171.521 268.739 C 162.486 276.036,158.983 280.153,158.029 284.600 C 157.745 285.920,157.195 287.900,156.806 289.000 C 154.689 294.988,155.192 299.706,158.234 302.376 C 159.616 303.590,160.800 303.970,160.800 303.200 C 160.800 302.980,161.160 302.800,161.600 302.800 C 162.553 302.800,162.651 301.906,161.777 301.181 C 160.189 299.863,159.343 295.027,160.615 294.539 C 161.411 294.234,162.400 292.311,162.400 291.069 C 162.400 289.435,164.304 285.165,166.483 281.910 C 168.836 278.396,169.779 278.092,171.817 280.191 C 175.541 284.025,175.943 287.356,173.028 290.224 C 171.834 291.400,170.360 293.225,169.752 294.281 C 169.145 295.336,167.997 297.190,167.201 298.400 C 163.194 304.487,163.149 308.890,167.063 311.875 C 168.746 313.159,170.289 312.394,169.279 310.777 C 168.750 309.931,168.984 309.019,169.628 309.417 C 170.213 309.779,170.063 308.636,169.413 307.776 C 168.589 306.688,168.651 305.301,169.536 305.020 C 170.462 304.726,170.849 303.938,172.442 299.089 C 173.971 294.435,177.600 290.301,177.600 293.213 C 177.600 294.824,178.862 294.633,180.519 292.770 L 182.094 291.000 183.947 293.068 C 184.966 294.205,186.340 296.179,187.000 297.454 C 188.405 300.168,188.924 300.800,189.748 300.800 C 190.739 300.800,190.812 301.389,190.007 302.892 C 188.781 305.179,190.489 305.646,192.440 303.558 C 193.750 302.154,193.995 299.955,192.987 298.624 C 192.664 298.196,192.400 297.440,192.400 296.942 C 192.400 296.370,191.820 295.571,190.819 294.767 C 186.003 290.897,186.259 287.186,191.408 286.227 C 192.559 286.013,193.454 285.445,194.639 284.175 C 196.726 281.940,199.083 281.667,202.000 283.322 C 205.055 285.056,208.178 286.600,208.646 286.606 C 208.891 286.609,209.405 286.872,209.788 287.190 C 210.567 287.837,211.111 288.171,213.646 289.564 C 215.049 290.334,216.040 290.538,218.600 290.583 C 221.778 290.638,222.161 290.756,225.822 292.813 C 227.781 293.912,230.253 295.099,234.600 297.024 C 235.920 297.609,238.300 298.697,239.889 299.443 C 242.101 300.482,243.304 300.800,245.027 300.800 C 246.812 300.800,247.743 301.062,249.538 302.070 C 254.158 304.665,259.426 307.183,260.251 307.192 C 261.065 307.200,262.541 307.729,265.600 309.107 C 266.370 309.454,269.160 311.824,271.800 314.374 C 280.072 322.363,285.001 326.663,294.400 334.090 C 296.436 335.699,298.827 337.488,305.000 342.024 C 314.500 349.004,317.659 350.330,315.876 346.590 C 315.015 344.784,315.012 344.800,316.213 344.800 C 319.999 344.800,316.975 338.880,308.852 330.389 C 304.505 325.846,304.544 325.802,310.012 329.053 C 319.896 334.931,323.211 335.509,323.866 331.470 C 324.339 328.557,317.718 320.544,300.011 302.600 C 292.848 295.340,286.453 288.590,285.801 287.600 C 284.467 285.573,281.019 281.197,277.416 276.957 C 276.087 275.394,273.920 272.700,272.600 270.972 C 262.881 258.246,253.442 247.252,247.757 242.037 C 235.643 230.925,228.170 222.350,229.802 221.436 C 230.231 221.196,231.150 220.453,231.846 219.784 C 233.271 218.415,234.842 217.600,236.055 217.600 C 237.173 217.600,242.323 213.709,243.040 212.323 C 243.359 211.705,243.931 211.194,244.310 211.187 C 244.690 211.181,246.075 210.641,247.390 209.987 C 248.704 209.334,249.976 208.800,250.215 208.800 C 250.454 208.800,251.168 208.260,251.800 207.600 C 252.432 206.940,253.219 206.400,253.548 206.400 C 255.924 206.400,260.225 204.099,260.836 202.500 C 261.025 202.005,261.457 201.600,261.796 201.600 C 262.134 201.600,262.723 201.435,263.105 201.233 C 263.487 201.031,264.633 200.500,265.652 200.053 C 266.670 199.607,267.848 198.768,268.269 198.190 C 268.703 197.594,270.206 196.644,271.738 195.998 C 275.663 194.342,278.144 192.626,278.898 191.046 C 279.381 190.031,279.897 189.601,280.876 189.392 C 284.117 188.701,288.388 186.994,290.538 185.532 C 292.064 184.494,293.662 183.793,295.138 183.513 C 299.546 182.676,303.115 181.346,305.872 179.512 C 306.931 178.808,308.076 178.400,308.995 178.400 C 309.793 178.400,311.290 178.209,312.323 177.975 C 318.296 176.624,317.891 176.744,320.881 175.431 C 321.696 175.073,322.596 174.558,322.881 174.285 C 323.632 173.570,325.502 172.800,326.490 172.800 C 326.959 172.800,327.896 172.632,328.572 172.427 C 329.247 172.222,330.610 171.830,331.600 171.555 C 334.058 170.873,336.839 169.464,337.779 168.425 C 338.826 167.265,340.483 166.578,343.600 166.009 C 347.124 165.366,349.919 164.797,351.600 164.380 C 352.370 164.189,355.340 163.472,358.200 162.787 C 361.060 162.102,363.850 161.396,364.400 161.217 C 364.950 161.039,366.210 160.664,367.200 160.385 C 383.005 155.923,398.000 148.329,398.000 144.785 C 398.000 143.079,395.446 141.871,393.695 142.748 C 371.556 153.833,366.980 156.000,365.708 156.000 C 365.387 156.000,364.646 156.325,364.062 156.723 C 362.691 157.657,355.737 159.872,352.436 160.427 C 351.026 160.664,348.236 161.365,346.236 161.984 C 344.236 162.604,341.520 163.325,340.200 163.588 C 337.314 164.162,335.242 164.599,332.700 165.172 C 327.452 166.354,326.041 166.622,320.000 167.584 C 314.927 168.391,306.547 169.550,302.800 169.962 C 299.241 170.353,296.555 170.628,286.900 171.588 C 284.755 171.801,280.570 172.163,277.600 172.391 C 274.630 172.619,270.302 172.985,267.982 173.203 C 260.027 173.951,258.996 173.407,262.300 170.202 C 263.125 169.402,264.485 168.085,265.323 167.274 C 267.837 164.840,268.811 163.380,269.117 161.586 C 269.297 160.531,269.705 159.714,270.188 159.441 C 271.365 158.775,272.606 157.114,272.480 156.371 C 272.419 156.009,272.815 155.420,273.361 155.062 C 273.907 154.705,274.940 153.555,275.658 152.506 C 276.955 150.611,278.688 148.680,282.700 144.659 C 283.855 143.501,284.800 142.256,284.800 141.891 C 284.800 141.526,285.160 141.035,285.600 140.800 C 286.040 140.565,286.400 140.012,286.400 139.571 C 286.400 139.131,287.209 137.927,288.198 136.894 C 289.241 135.806,289.917 134.762,289.807 134.409 C 289.545 133.564,289.986 133.029,291.480 132.379 C 292.184 132.073,292.994 131.377,293.280 130.833 C 293.566 130.289,294.475 129.152,295.300 128.306 C 297.454 126.097,298.632 123.664,298.021 122.686 C 297.567 121.958,298.314 120.855,299.291 120.813 C 299.842 120.789,300.964 118.687,300.982 117.645 C 300.997 116.770,301.261 116.529,302.600 116.165 C 305.768 115.305,306.740 114.731,307.834 113.073 C 308.441 112.153,309.608 110.693,310.428 109.830 C 311.248 108.966,312.150 107.526,312.434 106.630 C 312.717 105.733,313.274 104.525,313.670 103.944 C 314.067 103.363,314.619 102.204,314.896 101.368 C 315.256 100.282,315.880 99.555,317.080 98.824 C 318.712 97.829,324.000 91.965,324.000 91.150 C 324.000 90.927,324.561 89.929,325.247 88.932 C 326.328 87.360,326.469 86.862,326.308 85.184 C 326.090 82.914,325.992 83.086,328.794 80.795 C 330.000 79.808,331.317 78.730,331.721 78.400 C 334.805 75.875,336.912 72.397,336.685 70.204 L 336.461 68.031 340.631 63.816 C 343.218 61.200,344.800 59.287,344.800 58.774 C 344.800 57.572,345.415 56.602,347.279 54.863 C 348.324 53.888,348.847 53.099,348.700 52.716 C 348.211 51.442,342.707 50.809,339.600 51.669 M186.721 271.475 C 190.046 274.102,190.224 274.724,188.564 277.922 C 187.057 280.828,183.038 284.000,180.864 284.000 C 179.455 284.000,175.200 278.405,175.200 276.553 C 175.200 275.571,178.120 272.806,179.172 272.791 C 179.990 272.780,181.321 271.683,182.196 270.300 C 183.146 268.799,183.425 268.871,186.721 271.475 " stroke="none" fill="#fbfbfb" fill-rule="evenodd"></path><path id="path1" d="M0.000 200.000 L 0.000 400.000 200.000 400.000 L 400.000 400.000 400.000 200.000 L 400.000 0.000 200.000 0.000 L 0.000 0.000 0.000 200.000 M346.657 51.656 C 349.139 52.281,349.278 52.998,347.279 54.863 C 345.415 56.602,344.800 57.572,344.800 58.774 C 344.800 59.287,343.218 61.200,340.631 63.816 L 336.461 68.031 336.685 70.204 C 336.912 72.397,334.805 75.875,331.721 78.400 C 331.317 78.730,330.000 79.808,328.794 80.795 C 325.992 83.086,326.090 82.914,326.308 85.184 C 326.469 86.862,326.328 87.360,325.247 88.932 C 324.561 89.929,324.000 90.927,324.000 91.150 C 324.000 91.965,318.712 97.829,317.080 98.824 C 315.880 99.555,315.256 100.282,314.896 101.368 C 314.619 102.204,314.067 103.363,313.670 103.944 C 313.274 104.525,312.717 105.733,312.434 106.630 C 312.150 107.526,311.248 108.966,310.428 109.830 C 309.608 110.693,308.441 112.153,307.834 113.073 C 306.740 114.731,305.768 115.305,302.600 116.165 C 301.261 116.529,300.997 116.770,300.982 117.645 C 300.964 118.687,299.842 120.789,299.291 120.813 C 298.314 120.855,297.567 121.958,298.021 122.686 C 298.632 123.664,297.454 126.097,295.300 128.306 C 294.475 129.152,293.566 130.289,293.280 130.833 C 292.994 131.377,292.184 132.073,291.480 132.379 C 289.986 133.029,289.545 133.564,289.807 134.409 C 289.917 134.762,289.241 135.806,288.198 136.894 C 287.209 137.927,286.400 139.131,286.400 139.571 C 286.400 140.012,286.040 140.565,285.600 140.800 C 285.160 141.035,284.800 141.526,284.800 141.891 C 284.800 142.256,283.855 143.501,282.700 144.659 C 278.688 148.680,276.955 150.611,275.658 152.506 C 274.940 153.555,273.907 154.705,273.361 155.062 C 272.815 155.420,272.419 156.009,272.480 156.371 C 272.606 157.114,271.365 158.775,270.188 159.441 C 269.705 159.714,269.297 160.531,269.117 161.586 C 268.811 163.380,267.837 164.840,265.323 167.274 C 264.485 168.085,263.125 169.402,262.300 170.202 C 258.996 173.407,260.027 173.951,267.982 173.203 C 270.302 172.985,274.630 172.619,277.600 172.391 C 280.570 172.163,284.755 171.801,286.900 171.588 C 296.555 170.628,299.241 170.353,302.800 169.962 C 306.547 169.550,314.927 168.391,320.000 167.584 C 326.041 166.622,327.452 166.354,332.700 165.172 C 335.242 164.599,337.314 164.162,340.200 163.588 C 341.520 163.325,344.236 162.604,346.236 161.984 C 348.236 161.365,351.026 160.664,352.436 160.427 C 355.737 159.872,362.691 157.657,364.062 156.723 C 364.646 156.325,365.387 156.000,365.708 156.000 C 366.980 156.000,371.556 153.833,393.695 142.748 C 395.446 141.871,398.000 143.079,398.000 144.785 C 398.000 148.329,383.005 155.923,367.200 160.385 C 366.210 160.664,364.950 161.039,364.400 161.217 C 363.850 161.396,361.060 162.102,358.200 162.787 C 355.340 163.472,352.370 164.189,351.600 164.380 C 349.919 164.797,347.124 165.366,343.600 166.009 C 340.483 166.578,338.826 167.265,337.779 168.425 C 336.839 169.464,334.058 170.873,331.600 171.555 C 330.610 171.830,329.247 172.222,328.572 172.427 C 327.896 172.632,326.959 172.800,326.490 172.800 C 325.502 172.800,323.632 173.570,322.881 174.285 C 322.596 174.558,321.696 175.073,320.881 175.431 C 317.891 176.744,318.296 176.624,312.323 177.975 C 311.290 178.209,309.793 178.400,308.995 178.400 C 308.076 178.400,306.931 178.808,305.872 179.512 C 303.115 181.346,299.546 182.676,295.138 183.513 C 293.662 183.793,292.064 184.494,290.538 185.532 C 288.388 186.994,284.117 188.701,280.876 189.392 C 279.897 189.601,279.381 190.031,278.898 191.046 C 278.144 192.626,275.663 194.342,271.738 195.998 C 270.206 196.644,268.703 197.594,268.269 198.190 C 267.848 198.768,266.670 199.607,265.652 200.053 C 264.633 200.500,263.487 201.031,263.105 201.233 C 262.723 201.435,262.134 201.600,261.796 201.600 C 261.457 201.600,261.025 202.005,260.836 202.500 C 260.225 204.099,255.924 206.400,253.548 206.400 C 253.219 206.400,252.432 206.940,251.800 207.600 C 251.168 208.260,250.454 208.800,250.215 208.800 C 249.976 208.800,248.704 209.334,247.390 209.987 C 246.075 210.641,244.690 211.181,244.310 211.187 C 243.931 211.194,243.359 211.705,243.040 212.323 C 242.323 213.709,237.173 217.600,236.055 217.600 C 234.842 217.600,233.271 218.415,231.846 219.784 C 231.150 220.453,230.231 221.196,229.802 221.436 C 228.170 222.350,235.643 230.925,247.757 242.037 C 253.442 247.252,262.881 258.246,272.600 270.972 C 273.920 272.700,276.087 275.394,277.416 276.957 C 281.019 281.197,284.467 285.573,285.801 287.600 C 286.453 288.590,292.848 295.340,300.011 302.600 C 317.718 320.544,324.339 328.557,323.866 331.470 C 323.211 335.509,319.896 334.931,310.012 329.053 C 304.544 325.802,304.505 325.846,308.852 330.389 C 316.975 338.880,319.999 344.800,316.213 344.800 C 315.012 344.800,315.015 344.784,315.876 346.590 C 316.886 348.708,316.137 349.245,313.904 348.006 C 309.994 345.836,299.479 338.194,290.611 331.076 C 284.121 325.867,278.908 321.239,271.800 314.374 C 269.160 311.824,266.370 309.454,265.600 309.107 C 262.541 307.729,261.065 307.200,260.251 307.192 C 259.426 307.183,254.158 304.665,249.538 302.070 C 247.743 301.062,246.812 300.800,245.027 300.800 C 243.304 300.800,242.101 300.482,239.889 299.443 C 238.300 298.697,235.920 297.609,234.600 297.024 C 230.253 295.099,227.781 293.912,225.822 292.813 C 222.161 290.756,221.778 290.638,218.600 290.583 C 216.040 290.538,215.049 290.334,213.646 289.564 C 211.111 288.171,210.567 287.837,209.788 287.190 C 209.405 286.872,208.891 286.609,208.646 286.606 C 208.178 286.600,205.055 285.056,202.000 283.322 C 199.083 281.667,196.726 281.940,194.639 284.175 C 193.454 285.445,192.559 286.013,191.408 286.227 C 186.259 287.186,186.003 290.897,190.819 294.767 C 191.820 295.571,192.400 296.370,192.400 296.942 C 192.400 297.440,192.664 298.196,192.987 298.624 C 193.995 299.955,193.750 302.154,192.440 303.558 C 190.489 305.646,188.781 305.179,190.007 302.892 C 190.812 301.389,190.739 300.800,189.748 300.800 C 188.924 300.800,188.405 300.168,187.000 297.454 C 186.340 296.179,184.966 294.205,183.947 293.068 L 182.094 291.000 180.519 292.770 C 178.862 294.633,177.600 294.824,177.600 293.213 C 177.600 290.301,173.971 294.435,172.442 299.089 C 170.849 303.938,170.462 304.726,169.536 305.020 C 168.651 305.301,168.589 306.688,169.413 307.776 C 170.063 308.636,170.213 309.779,169.628 309.417 C 168.984 309.019,168.750 309.931,169.279 310.777 C 170.289 312.394,168.746 313.159,167.063 311.875 C 163.149 308.890,163.194 304.487,167.201 298.400 C 167.997 297.190,169.145 295.336,169.752 294.281 C 170.360 293.225,171.834 291.400,173.028 290.224 C 175.553 287.739,175.675 287.062,174.184 283.803 C 172.482 280.081,170.424 278.331,168.782 279.210 C 166.906 280.213,162.400 288.587,162.400 291.069 C 162.400 292.311,161.411 294.234,160.615 294.539 C 159.343 295.027,160.189 299.863,161.777 301.181 C 162.651 301.906,162.553 302.800,161.600 302.800 C 161.160 302.800,160.800 302.980,160.800 303.200 C 160.800 303.970,159.616 303.590,158.234 302.376 C 155.192 299.706,154.689 294.988,156.806 289.000 C 157.195 287.900,157.745 285.920,158.029 284.600 C 158.983 280.153,162.486 276.036,171.521 268.739 C 175.909 265.195,175.597 263.173,169.990 258.806 C 169.006 258.039,167.963 257.185,167.674 256.908 C 167.385 256.632,165.945 255.620,164.474 254.659 C 160.616 252.141,142.279 233.888,139.701 230.000 C 135.670 223.922,133.590 218.894,132.420 212.400 C 131.913 209.584,131.414 207.610,130.498 204.800 C 129.396 201.419,127.842 195.045,126.597 188.800 C 126.251 187.062,124.893 182.839,124.381 181.905 C 124.171 181.523,124.000 181.034,124.000 180.817 C 124.000 180.064,119.963 171.525,117.373 166.800 C 112.607 158.104,105.998 148.303,100.256 141.413 C 90.152 129.291,83.723 124.182,73.800 120.387 C 69.269 118.654,56.623 116.141,41.723 114.011 C 40.104 113.780,31.211 113.600,21.390 113.600 C 7.612 113.600,3.965 113.495,4.083 113.100 C 4.253 112.530,8.078 110.563,9.593 110.266 C 10.147 110.157,11.860 109.805,13.400 109.482 C 21.061 107.878,35.206 107.258,47.600 107.985 C 55.171 108.429,57.253 108.629,64.400 109.600 C 66.270 109.854,69.060 110.231,70.600 110.437 C 72.140 110.644,76.271 110.922,79.780 111.056 C 87.023 111.333,89.341 111.063,97.600 108.983 C 109.402 106.011,109.923 105.935,119.800 105.725 C 132.427 105.456,136.371 106.421,144.400 111.743 C 152.281 116.966,158.337 125.077,162.807 136.400 C 163.719 138.710,164.755 141.230,165.109 142.000 C 166.510 145.051,172.603 153.534,173.424 153.578 C 174.166 153.617,182.648 145.307,183.973 143.242 C 185.076 141.524,197.940 129.377,201.146 127.027 C 201.725 126.602,203.372 125.162,204.805 123.827 C 210.776 118.266,215.738 114.469,219.700 112.431 C 220.305 112.119,222.015 110.834,223.500 109.575 C 224.985 108.316,228.450 105.854,231.200 104.104 C 240.054 98.470,248.885 92.772,251.222 91.185 C 255.569 88.233,259.780 85.874,273.000 78.984 C 280.650 74.996,297.841 66.365,300.605 65.124 C 301.922 64.533,303.990 63.604,305.200 63.060 C 312.551 59.755,326.166 55.027,333.500 53.233 C 336.063 52.606,338.143 52.073,339.600 51.669 C 341.565 51.125,344.526 51.120,346.657 51.656 M182.196 270.300 C 181.321 271.683,179.990 272.780,179.172 272.791 C 178.120 272.806,175.200 275.571,175.200 276.553 C 175.200 278.405,179.455 284.000,180.864 284.000 C 183.038 284.000,187.057 280.828,188.564 277.922 C 190.224 274.724,190.046 274.102,186.721 271.475 C 183.425 268.871,183.146 268.799,182.196 270.300 " stroke="none" fill="#1c1c24" fill-rule="evenodd"></path></g></svg>
													<h1 style="color: white;">JustBookIn - Email de verificação válido por 15 minutos</h1>
												</td>
											</tr>
											<tr>
												<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
													<table cellpadding="0" cellspacing="0" width="100%" style="display: flex; justify-content: center;">
														<tr style="display: flex; justify-content: center; margin-top: 15px; margin-bottom: 15px;">
															<td>
																Olá, ' . $nomeDoUsuario . ', você criou uma conta na JustBookIn com o email "' . $emailUsuario . '". Clique no link abaixo para confirmar o seu email:
															</td>
														</tr>
														<tr style="display: flex; justify-content: center; margin-top: 15px; margin-bottom: 15px;">
															<td>
																<a href="' . $link . '">Confirmar Email</a>
															</td>
														</tr>
														<tr style="display: flex; justify-content: center; margin-top: 15px; margin-bottom: 15px;">
															<td>
																Ou use este link: <a href="' . $link . '">' . $link . '</a>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<center>
											<tr style="margin-top: 15px; margin-bottom: 15px;">
												<td align="center" bgcolor="#1c1c24" style="padding: 40px 0 30px 0;">
													<p style="color: white;">© ' . date("Y") . ' - JustBookIn</p>
												</td>
											</tr>
											</center>
										</tbody>
									</table>
								</body>';
								$mail->AltBody = $link;
								try {
									$mail->send();
								} catch (Exception $e) {
									?>
									<h2>Ops! houve um erro inesperado. Verifique se o E-mail digitado realmente existe. <a href="index.php">Voltar</a></h2>
									<?php
								}
								// Código para reenviar o e-mail
										?>
										<script>alert("E-mail enviado");</script>
										<?php
								
								} catch(Exception $e) {
									die ("Erro ao enviar um pedido de recuperação para $emailUsuario. ($e)");
							}//catch
						}
						?>
						<center><h1 class="titulo" style="margin-top: 0;">Olá <?php echo $dadosUsuario['nome']; ?>, VERIFIQUE SEU EMAIL</h1>
						<br>
						<h2>Sua conta foi criada, porém precisamos que você valide-a verificando a mensagem que foi enviada para o e-mail "<?php echo $dadosUsuario['email']; ?>"
						<br>
						<h3>Caso contrário, não será possível fazer login. (E-mail de verificação válido por 15 minutos)
						<h3>Se você já validou, <a href="index.php">faça login</a>
						<br>Não recebeu nenhum e-mail? Verifique a caixa de Spam ou reenvie o e-mail</h3></center>
						<center><input class="botao azul" type="button" onclick="reenviaEmail()" value="Clique aqui para reenviar o email"></center>
						<div class="footerFixado">©<?php echo date("Y"); ?> Todos os direitos reservados à JustBookIn.</div>
						<?
					}
					
				}
			} ?>
		</div>
	</main>
</body>
<script>

function reenviaEmail()
{
	var confirmacao = confirm("Tem certeza de que deseja reenviar o E-mail?");
	if (confirmacao)
	{
		location.reload();
	}
}

document.onkeydown = function(e) {
    if (e.key === "F5") {
        reenviaEmail();
		return false;
    }
};


</script>