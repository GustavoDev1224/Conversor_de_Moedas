<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Moedas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <?php

        // Cotação vinda da API do Banco Central
        $inicio = date("m-d-Y", strtotime("-7 days"));
        $fim = date("m-d-Y");

        $url = "https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial='$inicio'&@dataFinalCotacao='$fim'&\$top=1&\$orderby=dataHoraCotacao%20desc&\$format=json&\$select=cotacaoCompra,cotacaoVenda,dataHoraCotacao";

        $dados = json_decode(file_get_contents($url), true);

        $cotacao = $dados["value"][0]["cotacaoCompra"];

        // Valor informado pelo usuário
        $real = $_REQUEST["din"] ?? 0;

        // Equivalência do dólar
        $dolar = $real / $cotacao;

        // Formatação de moedas com internacionalização
        $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

        echo "<p>Seus "
            . numfmt_format_currency($padrao, $real, "BRL")
            . " equivalem a<strong>"
            . numfmt_format_currency($padrao, $dolar, "USD")
            . "</strong></p>";

        ?>

        <button onclick="javascript:history.go(-1)">&#x1f504; Voltar</button>

    </main>
</body>

</html>