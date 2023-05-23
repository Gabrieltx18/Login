<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
 
    $servername = "localhost";
    $username = "root";
    $password = "etec";
    $database = "Login";
    try {
        $cn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $cn->prepare("SELECT * FROM Usuarios WHERE nm_usuario = :usuario AND ds_senha = :senha");
        $stmt->bindParam(':usuario', $_POST['usuario']);
        $stmt->bindParam(':senha', $_POST['senha']);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['login'] = true;
            $_SESSION['usuario'] = $user['nm_usuario'];
            $_SESSION['senha'] = $user['ds_senha'];
            header('Location: login.php');
            exit;
        } else {
            echo "Usuário ou senha inválidos!";
        }
    } catch (PDOException $e) {
        echo "Erro ao conectar-se ao banco de dados: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>
        <input type="submit" value="Entrar">
    </form>
</body>
</html>
