<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>South park LOJA</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2 class="title-topo">South Park Loja Oficial com PHP</h2>
<div class="carrinho-container">
    <?php 
        $items = array( 
            ['nome' =>'Cartman','imagem' => 'cartman.jpg','preço' => '200'],
            ['nome' =>'Stan','imagem' => 'stan.jpg','preço' => '200'],
            ['nome' =>'Kenny','imagem' => 'kenny.jpg','preço' => '200'],
            ['nome' =>'Kyle','imagem' => 'kyle.jpg','preço' => '200'],
            ['nome' =>'Butters','imagem' => 'butters.jpg','preço' => '200'],
            ['nome' =>'Placa','imagem' => 'placa.jpg','preço' => '200']
        );

        foreach ($items as $key => $value) {
    ?>
        <div class="produto">
            <img src="<?php echo $value['imagem'] ?>" />
            <a class="addcarrinho" href="?adicionar=<?php echo $key ?>">Adicionar ao <br> Carrinho!</a>
        </div>
    <?php 
        }
    ?>
</div>

<?php 
if(isset($_GET['adicionar'])) {
    $idProduto = (int)$_GET['adicionar'];
    if(isset($items[$idProduto])) {
        if(isset($_SESSION['carrinho'][$idProduto])){
            $_SESSION['carrinho'][$idProduto]['quantidade']++;
        } else {
            $_SESSION['carrinho'][$idProduto] = array('quantidade' => 1, 'nome' =>$items[$idProduto]['nome'],'preço'=>$items[$idProduto]['preço']);
        }
        echo '<script>alert("O item foi adicionado ao carrinho.")</script>';
    } else {
        die('Você não pode adicionar um item que não existe');
    }
}

if(isset($_GET['remover'])) {
    $idProduto = (int)$_GET['remover'];
    if(isset($_SESSION['carrinho'][$idProduto])) {
        if($_SESSION['carrinho'][$idProduto]['quantidade'] > 1) {
            $_SESSION['carrinho'][$idProduto]['quantidade']--;
        } else {
            unset($_SESSION['carrinho'][$idProduto]);
        }
        echo '<script>alert("O item foi removido do carrinho.")</script>';
    }
}

if(isset($_GET['limpar'])) {
    unset($_SESSION['carrinho']);
    echo '<script>alert("O carrinho foi limpo.")</script>';
}
?>

<h2 class="title">Carrinho</h2>

<div class="carrinho-container">
    <?php 
    if(isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $key => $value){
            echo '<div class="carrinho-item">';
            echo '<p>Nome: '.$value['nome'].' | Quantidade:'.$value['quantidade'].' | <strong>Preço R$: '.($value['quantidade']*$value['preço']).'</strong></p>';
            echo '<div class="botoes">';
            echo '<a href="?adicionar='.$key.'" class="botao">+</a>';
            echo '<a href="?remover='.$key.'" class="botao">-</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Seu carrinho está vazio.</p>';
    }
    ?>
</div>


</body>
</html>
