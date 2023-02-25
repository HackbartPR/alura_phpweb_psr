<?php require_once __DIR__ . '/header.php'; ?>
    <main class="container">
        <?php if ($video) { ?>

            <form class="container__formulario" method="POST" action="/editar?id=<?= $video->id() ?>" enctype="multipart/form-data">
                <h2 class="formulario__titulo"><?= $video->title ?></h2>

                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="url">Link embed</label>
                    <input name="url" class="campo__escrita" required placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g" id='url' value='<?= $video->url ?>' />
                </div>


                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
                    <input name="titulo" class="campo__escrita" required placeholder="Neste campo, dê o nome do vídeo" id='titulo' value='<?= $video->title ?>' />
                </div>

                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="image">Capa do vídeo</label>
                    <input type='file' accept="image/*" name="image" class="campo__escrita" id='image' />
                </div>

                <input class="formulario__botao" type="submit" value="Atualizar" />
            </form>

        <?php } else { ?>

            <form class="container__formulario" method="POST" action="/novo" enctype="multipart/form-data">
                <h2 class="formulario__titulo">Envie um vídeo!</h2>

                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="url">Link embed</label>
                    <input name="url" class="campo__escrita" required placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g" id='url' />
                </div>


                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
                    <input name="titulo" class="campo__escrita" required placeholder="Neste campo, dê o nome do vídeo" id='titulo' />
                </div>

                <div class="formulario__campo">
                    <label class="campo__etiqueta" for="image">Capa do vídeo</label>
                    <input type='file' accept="image/*" name="image" class="campo__escrita" id='image' />
                </div>

                <input class="formulario__botao" type="submit" value="Enviar" />
            </form>

        <?php } ?>
    </main>

<?php require_once __DIR__ . '/footer.php';