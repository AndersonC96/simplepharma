<?php
session_start();

if (!isset($_SESSION['sess_username'])) {
    header('Location: login.php');
    exit();
}

include('conexaodbAdmin.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['sess_username'];

    // Recuperar o `id` com base no `username`
    $stmt_user = $mysqli->prepare("SELECT id FROM usuarios WHERE username = ?");
    $stmt_user->bind_param('s', $username);
    $stmt_user->execute();
    $stmt_user->bind_result($user_id);
    $stmt_user->fetch();
    $stmt_user->close();

    if (!$user_id) {
        echo "<script>alert('Usuário inválido.'); window.location.href = 'login.php';</script>";
        exit();
    }

    $local = htmlspecialchars($_POST['local']);
    $phone = htmlspecialchars($_POST['phone']);
    $anydesk = htmlspecialchars($_POST['anydesk']);
    $titulo = htmlspecialchars($_POST['titulo']);
    $servico = $_POST['servico'];
    $tecnico_id = htmlspecialchars($_POST['id']);
    $dateFrom = htmlspecialchars($_POST['dateFrom']);
    $status = 'Aberto'; // Definindo o status como "Aberto"

    // Buscar o nome do técnico com base no ID
    $stmt_tecnico = $mysqli->prepare("SELECT nome FROM tecnicos WHERE id = ?");
    $stmt_tecnico->bind_param('i', $tecnico_id);
    $stmt_tecnico->execute();
    $stmt_tecnico->bind_result($tecnico_nome);
    $stmt_tecnico->fetch();
    $stmt_tecnico->close();

    // Inserir os dados no banco de dados usando prepared statement
    $stmt = $mysqli->prepare("INSERT INTO chamados (user_id, usuario, local, telefone, anydesk, titulo, servico, tecnico, datahora, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssssssss', $user_id, $username, $local, $phone, $anydesk, $titulo, $servico, $tecnico_nome, $dateFrom, $status);

    if ($stmt->execute()) {
        $chamado_id = $stmt->insert_id;

        // Verifica e manipula os arquivos anexados
        if (!empty($_FILES['anexos']['name'][0])) {
            $upload_dir = '../uploads/' . $user_id . '/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            foreach ($_FILES['anexos']['name'] as $key => $filename) {
                $unique_filename = time() . '_' . basename($filename);
                $filepath = $upload_dir . $unique_filename;

                if (move_uploaded_file($_FILES['anexos']['tmp_name'][$key], $filepath)) {
                    $stmt_anexo = $mysqli->prepare("INSERT INTO anexos_chamados (chamado_id, user_id, filepath) VALUES (?, ?, ?)");
                    $stmt_anexo->bind_param('iis', $chamado_id, $user_id, $filepath);
                    $stmt_anexo->execute();
                }
            }
        }

        echo "<script>
            alert('Chamado aberto com sucesso!');
            window.location.href = 'chamadosAbertos.php';
        </script>";
    } else {
        $error = $stmt->error;
        echo "<script>
            alert('Erro ao abrir o chamado: " . addslashes($error) . "');
            window.location.href = 'abrirchamadoAdmin.php';
        </script>";
    }
}
?>
