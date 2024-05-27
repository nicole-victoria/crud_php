
<?php
session_start();
require 'conexao.php';
if (isset($_POST['create_usuario'])) {
	$nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
	$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
	$data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
	$curso = mysqli_real_escape_string($conexao, trim($_POST['curso']));
	$senha = isset($_POST['senha']) ? mysqli_real_escape_string($conexao, password_hash(trim($_POST['senha']), PASSWORD_DEFAULT)) : '';
	$sql = "INSERT INTO usuario (nome, data_nasc, email, curso, senha) VALUES ('$nome', '$data_nascimento', '$email', '$curso', '$senha')";
	mysqli_query($conexao, $sql);
	if (mysqli_affected_rows($conexao) > 0) {
		$_SESSION['mensagem'] = 'Usuário criado com sucesso';
		header('Location: index.php');
		exit;
	} else {
		$_SESSION['mensagem'] = 'Usuário não foi criado';
		header('Location: index.php');
		exit;
	}
}
if (isset($_POST['update_usuario'])) {
	$usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);
	$nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
	$data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
	$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
	$curso = mysqli_real_escape_string($conexao, trim($_POST['curso']));
	$senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));
	$sql = "UPDATE usuario SET nome = '$nome', data_nasc = '$data_nascimento', email = '$email', curso = '$curso'";
	if (!empty($senha)) {
		$sql .= ", senha='" . password_hash($senha, PASSWORD_DEFAULT) . "'";
	}
	$sql .= " WHERE id = '$usuario_id'";
	mysqli_query($conexao, $sql);
	if (mysqli_affected_rows($conexao) > 0) {
		$_SESSION['mensagem'] = 'Usuário atualizado com sucesso';
		header('Location: index.php');
		exit;
	} else {
		$_SESSION['mensagem'] = 'Usuário não foi atualizado';
		header('Location: index.php');
		exit;
	}
}
if (isset($_POST['delete_usuario'])) {
	$usuario_id = mysqli_real_escape_string($conexao, $_POST['delete_usuario']);
	$sql = "DELETE FROM usuario WHERE id = '$usuario_id'";
	mysqli_query($conexao, $sql);
	if (mysqli_affected_rows($conexao) > 0) {
		$_SESSION['message'] = 'Usuário deletado com sucesso';
		header('Location: index.php');
		exit;
	} else {
		$_SESSION['message'] = 'Usuário não foi deletado';
		header('Location: index.php');
		exit;
	}
}
?>