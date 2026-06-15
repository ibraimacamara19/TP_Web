<?php include_once 'includes/idioma.php'; ?>

<!DOCTYPE html>
<html lang="<?php echo $idioma_atual; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t("nome_sistema"); ?></title>
    <link rel="stylesheet" href="/TP_Web/css/style.css?v=<?php echo time(); ?>">
</head>
<body>

<header class="topo no-print">
    <div>
        <h1><?php echo t("nome_sistema"); ?></h1>
        <p><?php echo t("subtitulo_sistema"); ?></p>
    </div>

    <div class="seletor-idioma">
        <span><?php echo t("idioma"); ?>:</span>

        <a href="<?php echo link_idioma('pt'); ?>" class="<?php if ($idioma_atual === 'pt') echo 'idioma-ativo'; ?>">
            PT
        </a>

        <a href="<?php echo link_idioma('en'); ?>" class="<?php if ($idioma_atual === 'en') echo 'idioma-ativo'; ?>">
            EN
        </a>
    </div>
</header>