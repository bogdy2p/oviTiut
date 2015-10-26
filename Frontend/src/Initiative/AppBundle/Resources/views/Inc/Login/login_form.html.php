<form role="form" id="login_form2" action="<?php echo $this->container->getParameter('fileUrl'); ?>users/authentication" method="POST">
  <div class="form-group">
    <label class="float_label no-border" for="username">username</label>
    <input name="username" type="username" data-for="username" class="form-control username" id="InputEmail" placeholder="Username" <?php if(isset($_COOKIE['username']) && isset($_COOKIE['remember'])) { echo "value='".$_COOKIE['username']."'"; } ?>>
  </div>
  <div class="form-group">
    <label class="float_label no-border" for="password">password</label>
    <input name="password" type="password" data-for="password" class="form-control password" id="InputPassword" placeholder="Password">
  </div>
  <div class="checkbox">
    <div class="row">
      <div class="col-xs-6">
        <label class="loginCheckbox remember_label">
          <div id="svg_checkbox"></div>
          <input type="checkbox" class="remember_me" <?php if(isset($_COOKIE['remember'])) { echo "checked"; } ?>> <p class="evo-text-smaller evo-white">remember me</p>
        </label>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
          <div class="evo-space-biggest"></div>
          <p class="evo-text-big evo-text-center evo-ff5 loose"><a href="mailto:mbsupport@mbww.com?subject=Forget my Dash password" class="evo-white">forgot your info?</a>
        </p>
      </div>
    </div>
  </div>
  <button type="submit" class="btn btn-default hidden">Submit</button>
  <div id="submitBtn_container">
    <div id="submitBtn">
      <?php echo $view->render('InitiativeAppBundle:Inc:Login/enter_svg.html.php'); ?>
    </div>
  </div>
</form>