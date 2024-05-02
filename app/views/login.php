<div class="login-box">

  <div class="login-logo card-header bg-secondary">
    <a href="home">
        <img src="<?= ASSETS; ?>img/AdminLTELogo.png" width="20%" alt="">
        <p class="login-box-msg font-weight-bold m-0 p-0">eReserv</p>
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      <p class="login-box-msg font-weight-bold">Connectez vous démarrer une session</p>

      <form action="log" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Mot de passe">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Se souvenir de moi
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 mt-2">
            <button type="submit" class="btn btn-secondary btn-block">Se connecter</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->