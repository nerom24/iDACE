<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= URL ?>index">iDACE - </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?= URL ?>index"">Home</a>
        </li>
        <li class=" nav-item">
            <a class="nav-link active" href="<?= URL ?>actividades">Actividades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Planificación</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Profesores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#">Departamentos</a>
        </li>
      </ul>
      <div class="d-flex">
        <div class="collapse navbar-collapse" id="exCollapsingNavbar">
          <ul class="nav navbar-nav flex-row justify-content-between ml-auto">
            <li class="nav-item"><a href="<?= URL ?>perfil" class="nav-link active"><?= $_SESSION['name_user'] . ' | ' ?></a></li>
            <li class="nav-item"><a href="<?= URL ?>logout" class="nav-link active">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>