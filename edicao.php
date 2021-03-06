<?php
    function unlinkArquivo($con, $id, $capa=FALSE, $contra=FALSE, $foto=FALSE){
        if ($capa){
            $sql = "SELECT capa FROM livro WHERE id = $id";
            $result = mysqli_fetch_array(mysqli_query($con, $sql));
            unlink("_imagens/" . $result['capa']);
        }

        if ($contra){
            $sql = "SELECT contra FROM livro WHERE id = $id";
            $result = mysqli_fetch_array(mysqli_query($con, $sql));
            unlink("_imagens/" . $result['contra']);
        }

        if ($foto){
            $sql = "SELECT foto FROM autor WHERE id = $id";
            $result = mysqli_fetch_array(mysqli_query($con, $sql));
            unlink("_imagens/" . $result['foto']);
        }
        
    }

    $form = $_POST['formulario'];

    include_once('Conexao.php');

    if ($form == 'LIVRO'){

        $id = $_POST["id"];

        $gel = $_POST["genero"];
        $isbn = $_POST["isbn"];
        $titulo = $_POST["titulo"];
        $cdd = $_POST["cdd"];
        $autor = $_POST["nomeautor"];
        $data = $_POST["dataR"];
        $exemp = $_POST["exemp"];

        $capa = $_FILES["capa"]["name"];
        $ccapa = $_FILES["contracapa"]["name"];
        
        $targetc = "_imagens/" . $capa;
        $targetcc = "_imagens/" . $ccapa;
        
        if (!empty($data)) {
            $data = "'" . $data . "'";
        }else{
            $data = 'default';
        }

        if (empty($capa) && empty($ccapa)){
            $sql = "UPDATE livro 
                    SET genero = '$gel', isbn = '$isbn', titulo = '$titulo', cdd = '$cdd', autor = $autor, dataRemessa = $data, exemplares = $exemp
                    WHERE id = $id
                    LIMIT 1";
        }else if(!empty($capa) && empty($ccapa)){

            unlinkArquivo($con, $id, TRUE);

            $sql = "UPDATE livro 
                    SET genero = '$gel', isbn = '$isbn', titulo = '$titulo', cdd = '$cdd', autor = $autor, dataRemessa = $data, exemplares = $exemp, capa = '$capa'
                    WHERE id = $id
                    LIMIT 1";
            move_uploaded_file($_FILES["capa"]["tmp_name"], $targetc);

        }else if(!empty($ccapa) && empty($capa)){

            unlinkArquivo($con, $id, FALSE, TRUE);

            $sql = "UPDATE livro 
                    SET genero = '$gel', isbn = '$isbn', titulo = '$titulo', cdd = '$cdd', autor = $autor, dataRemessa = $data, exemplares = $exemp, contra = '$ccapa'
                    WHERE id = $id
                    LIMIT 1";
            move_uploaded_file($_FILES["contracapa"]["tmp_name"], $targetcc);

        }else{

            unlinkArquivo($con, $id, TRUE, TRUE);

            $sql = "UPDATE livro 
                    SET genero = '$gel', isbn = '$isbn', titulo = '$titulo', cdd = '$cdd', autor = $autor, dataRemessa = $data, exemplares = $exemp, capa = '$capa', contra = '$ccapa'
                    WHERE id = $id
                    LIMIT 1";
            move_uploaded_file($_FILES["capa"]["tmp_name"], $targetc);
            move_uploaded_file($_FILES["contracapa"]["tmp_name"], $targetcc);
        }
        
        mysqli_query($con, $sql);


       header('Location: listarLivros.php');
    }elseif ($form == 'AUTOR'){

        $id = $_POST["id"];

        $nome = $_POST["nomeautor"];
        $desc = $_POST["desc"];
        $data = $_POST["datanasc"];
        $autmes = $_POST["autordomes"];

        $foto = $_FILES["fotoAutor"]["name"];
        
        if (empty($autmes)){
            $autmes = 'false';
        }

        if (!empty($data)) {
            $data = "'" . $data . "'";
        }else{
            $data = 'default';
        }

        if (!empty($foto)) {

            unlinkArquivo($con, $id, FALSE, FALSE, TRUE);

            $sql = "UPDATE autor
                    SET nome = '$nome', descricao = '$desc', dataNasc = $data, autordomes = $autmes, foto = '$foto'
                    WHERE id = $id
                    LIMIT 1";
            $target = "_imagens/" . $foto;
            move_uploaded_file($_FILES["fotoAutor"]["tmp_name"], $target);
            
        }else{
            $sql = "UPDATE autor
                    SET nome = '$nome', descricao = '$desc', dataNasc = $data, autordomes = $autmes
                    WHERE id = $id
                    LIMIT 1";
        }

        mysqli_query($con, $sql);

        header('Location: listarAutores.php');
        
    }elseif ($form == 'ALUNO'){
        
        $id = $_POST['id'];

        $ano = $_POST["ano"];
        $numero = $_POST["numero"];
        $turma = $_POST["turma"];
        $nome = $_POST["nome"];

        $sql = "UPDATE aluno
                SET nomeleitor = '$nome', numero = $numero, ano = '$ano', turma = '$turma'
                WHERE id = $id
                LIMIT 1";

        mysqli_query($con, $sql);

        header('Location: pendencias.php');

    }elseif ($form == 'PROFESSOR'){

        $id = $_POST['id'];

        $nome = $_POST["nome"];

        $sql = "UPDATE professor
                SET nomeleitor = '$nome'
                WHERE id = $id
                LIMIT 1";

        mysqli_query($con, $sql);

        header('Location: pendencias.php');
    }

?>