<?php


session_start();

if (!isset($_SESSION['login'])) {
	$_SESSION['login']="incorreto";
}
if ($_SESSION['login']=="correto" && isset($_SESSION['login'])) {
	//aqui colocamos o conteudo

		if($_SERVER['REQUEST_METHOD']=="GET"){
		if (isset($_GET['realizador'])&& is_numeric($_GET['realizador'])) {
			$idRealizador = $_GET['realizador'];
			$con=new mysqli("localhost","root", "","projeto-filmes");

			if ($con->connect_errno!=0) {
				echo "<h1>Ocorreu um erro no acesso á base de dados.<br>".$con->connect_error."</h1>";
				exit();
			}
			$sql="Select * from realizadores where id_realizador=?";
			$stm=$con->prepare($sql);
			if ($stm!=false) {
				$stm->bind_param("i", $idRealizador);
				$stm->execute();
				$res=$stm->get_result();
				$realizador=$res->fetch_assoc();
				$stm->close();
			}
			?>
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="ISO-8859-1">
				<title>Editar Realizadores</title>
	            <h1>Editar Realizadores</h1>
	        </head>
				<form action="realizadores_update.php" method="POST">
			<label>Nome</label><input type="text" name="nome" required value="<?php echo $realizador['nome']; ?>"><br>
			<label>Nacionalidade</label><input type="text" name="nacionalidade" value="<?php echo $realizador['nacionalidade'];?>"><br>
	        <input type="submit" name="enviar">
		</form>
		</body>
			
			<?php
			}
			else{
				echo "<h1>Houve um erro ao processar o seu pedido.<br> Dentro de segundos irá ser rencaminhado!</h1>";
				header ("refresh:5; url=index.php");
				
			}
		
		?>
		</html>
	<?php
}







}//login
else{
	echo 'Para entrar nesta página necessita de efetuar <a href="login.php">login</a>';
	header('refresh:2;url=login.php');
}


?>