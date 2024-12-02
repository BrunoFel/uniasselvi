<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página não encontrada</title>

    <!-- Meta -->    
    <link type="text/css" rel="stylesheet" href="<?= URL_PROJETO;?>/public/css/erro.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.min.css" />
  </head>

  <body>

    <!-- Error container starts -->
    <div class="error-container">

      <!-- Container starts -->
      <div class="container">

        <!-- Row starts -->
        <div class="row justify-content-center">
          <div class="col-sm-6">
            <img width="90%" src="<?= URL_PROJETO;?>/public/img/error.svg" class="img-fluid mb-5" alt="Bootstrap Gallery">
            <h2 class="fw-bold mb-4">
            😠 Grrr.............. 😠 <br> O que você está tentando fazer?
            </h2>
            <p>Como você chegou aqui é um mistério para mim. <br> Afinal, essa página não existe. </p>
            <p> Volte para o lugar de onde veio e pare de bisbilhotar o meu site! </p>

            <a href="<?= URL_PROJETO;?>" class="btn btn-dark rounded-5 px-4 py-2 fs-5">Voltar para Home</a>
          </div>
        </div>
        <!-- Row ends -->

      </div>
      <!-- Container ends -->

    </div>
    <!-- Error container ends -->

  </body>

</html>