<?php

require('../../database/conexao.php');

$sql = "SELECT * FROM tbl_categoria";

$resultado = mysqli_query($conexao, $sql);

$produtoId = $_GET["id"];

$sql2 = "SELECT * FROM tbl_produto WHERE id = $produtoId";

$resultado2 = mysqli_query($conexao, $sql2);

$produto = mysqli_fetch_array($resultado2);

$sql3 = "SELECT * FROM tbl_categoria WHERE id = $produto[9]";

$selecionar = mysqli_fetch_array(mysqli_query($conexao, $sql3));

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../styles-global.css" />
  <link rel="stylesheet" href="./editar.css" />
  <title>Editar Produtos</title>

</head>

<body>

<?php include('../../componentes/header/header.php'); ?>

  <div class="content">

    <section class="produtos-container">

      <main>

        <form class="form-produto" method="POST" action="../acoes.php" enctype="multipart/form-data">

          <input type="hidden" name="acao" value="editar" />

          <input type="hidden" name="produtoId" value="<?php echo $produtoId ?>" />

          <h1>Editar Produto</h1>

          <ul>

            <?php
            
              if(isset($_SESSION["erros"])){

                foreach($_SESSION["erros"] as $erro){

                  echo "<li> $erro </li>";

                }

                session_destroy();

              }
            
            ?>

          </ul>

          <div class="input-group span2">
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" value="<?php echo $produto["descricao"] ?>" id="descricao" >
          </div>

          <div class="input-group">
            <label for="peso">Peso</label>
            <input type="text" name="peso" value="<?php echo number_format($produto["peso"], 2, ",", ".") ?>" id="peso">
          </div>

          <div class="input-group">
            <label for="quantidade">Quantidade</label>
            <input type="text" name="quantidade" value="<?php echo number_format($produto["quantidade"], 2, ",", ".") ?>" id="quantidade">
          </div>

          <div class="input-group">
            <label for="cor">Cor</label>
            <input type="text" name="cor" value="<?php echo $produto["cor"] ?>" id="cor">
          </div>

          <div class="input-group">
            <label for="tamanho">Tamanho</label>
            <input type="text" value="<?php echo number_format($produto["tamanho"], 2, ",", ".")?>" name="tamanho" id="tamanho">
          </div>

          <div class="input-group">
            <label for="valor">Valor</label>
            <input type="text" name="valor" value="<?php echo number_format($produto["valor"], 2, ",", ".") ?>" id="valor">
          </div>

          <div class="input-group">
            <label for="desconto">Desconto</label>
            <input type="text" name="desconto" value="<?php echo number_format($produto["desconto"], 2, ",", ".") ?>" id="desconto">
          </div>

          <div class="input-group">

            <label for="categoria">Categoria</label>

            <select id="categoria" name="categoria">

              <!-- Início da listagem de categorias vindo do banco -->
              <?php

              while ($categoria = mysqli_fetch_array($resultado)) {

              ?>

                <?php

                if ($categoria["descricao"] == $selecionar["descricao"]) {

                ?>
                  <option value="<?php echo $categoria["id"] ?>" selected><?php echo $selecionar["descricao"] ?></option>

                <?php

                } else {

                ?>

                  <option value="<?php echo $categoria["id"] ?>"><?php echo $categoria["descricao"] ?></option>
              <?php }
              } ?>
              <!-- Fim -->

              <!-- <option value="" > -->

              <!-- </option> -->

            </select>

          </div>

          <div class="input-group">
            <label for="categoria">Foto</label>
            <input type="file" name="foto" id="foto" accept="image/*" />
          </div>

          <!-- <button onclick="javascript:window.location.href = '../..'">Cancelar</button> -->

          <a href="../../produtos/index.php" id="botaoCancelar">Cancelar</a>

          <button>Salvar</button>

        </form>

      </main>

    </section>

  </div>

  <footer>
    SENAI 2021 - Todos os direitos reservados
  </footer>

</body>

</html>