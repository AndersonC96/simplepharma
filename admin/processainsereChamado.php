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
        header('Location: login.php?err=invalid_user');
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

    // Inserir os dados no banco de dados usando prepared statement
    $stmt = $mysqli->prepare("INSERT INTO chamados (user_id, usuario, local, telefone, anydesk, titulo, servico, tecnico, datahoraaber, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssssssss', $user_id, $username, $local, $phone, $anydesk, $titulo, $servico, $tecnico_id, $dateFrom, $status);

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

        header('Location: chamadosAbertos.php?msg=success');
        exit();
    } else {
        header('Location: abrirchamadoAdmin.php?err=insert_failed');
        exit();
    }
}
?>
