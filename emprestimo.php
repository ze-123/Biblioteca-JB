<?php
	include_once('autenticador.php');
	include_once('varcod.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>BJB</title>
		<link rel="stylesheet" type="text/css" href="_css/estilo.css">
		<link rel="stylesheet" type="text/css" href="_css/emprestimo.css">
		<link rel="shortcut icon" type="image/x-png" href="_interface/logo.png">
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
		<script type="text/javascript" src="_javascript/pesquisa.js"></script>
	</head>

	<body>
		
		<header class="cabecalho">
			<div id="logo">
				<img src="_interface/logo.png" width="100%">
			</div>

		</header>	

		<?php include_once('menu.html'); ?>

		<main class="conteudo">

			<div class="bloco">
				<form action="empAluno.php" method="POST">
					<h1>Empréstimos para Alunos</h1>
					<table class="formulario">
						
						<tr>
							<td>Ano
								<select name="ano" id="ano" class="field" required>
									<?php
										$anos = ['1', '2', '3'];
										foreach ($anos as $ano){
											echo '<option value="' . $ano . '">' . $ano . '°' . '</option>';
										}
									?>
								</select></td>
						</tr>

						<tr>
							
							<td>Turma
								<select name="turma" id="turma" class="field" required>
									<?php
                                        for ($i = 0; $i <= 3; $i++){
                                            echo '<option value="' . $valores[$i] . '">' . $cursos[$i] . '</option>';
                                        }
                                    ?>
								</select>
							</td>
						</tr>


						<tr>
							
							<td>Número<input type="number" name="numero" id="numero" class="field" min="1" max="50" required="true"></td>
						</tr>

						<tr>
							<td>Nome<input type="text" name="nome" class="field" maxlength="85"></td>
						</tr>

						<tr>
							
							<td>Livro
								<input type="text" name="livroTitulo" id="livroTitulo" class="field" autocomplete="off" required>
								<select class="resultado" name="livroId" required>
									
								</selct>
							</td>
						</tr>

						<tr>
							<th><input type="submit" class="enter" value="Emprestar Livro"></th>
						</tr>
						
					</table>
				</form>
				
			</div><!--
		
		--><div class="bloco">
				<form action="empProf.php" method="POST">
					<h1>Empréstimos para Professores</h1>
					<table class="formulario">
						
						<tr>
							<td>Nome
								<input type="text" name="nome" id="nome" class="field" maxlength="85" required="true" list="autocomp">
								
								<datalist id="autocomp">
									<?php
										include_once('Conexao.php');

										$sql = 'SELECT nomeleitor FROM professor';
										$r = mysqli_query($con, $sql);

										while ($result = mysqli_fetch_array($r)) {
											echo '<option value="' . $result['nomeleitor'] . '"></option>';
										}
									
									?>
								</datalist>
							</td>
						</tr>

						<tr>
							
							<td>Livro
								<input type="text" name="livroTitulo" id="livroTitulo2" class="field" autocomplete="off" required>
								<select class="resultado2" name="livroId" required>
									
								</selct>
							</td>
						</tr>

						<tr>
							<th><input type="submit" class="enter" value="Emprestar Livro"></th>
						</tr>
						
					</table>
				</form>
			</div>

		</main>

	</body>
</html>