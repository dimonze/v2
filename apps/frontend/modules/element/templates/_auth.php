<a class="navIco nav-auth" href="#"></a>
<div class="hidden authBlock">
  <?php if ($sf_user->isAuthenticated()): ?>
    <form class="linksWhite" action="<?= url_for('@default?module=element&action=signOut') ?>">
      <strong><?= $sf_user->fio ?></strong>
      <input type="submit" value="<?= __('Sign out') ?>" class="fl"/>
    </form>
  <?php else: ?>
    <form class="authForm linksWhite" action="<?= url_for('element/signIn') ?>" method="post">
      <input type="text" name="user[email]" placeholder="<?= __('Enter email/login') ?>"/>
      <input type="password" name="user[pass]" placeholder="<?= __('Enter your password') ?>"/>
      <input type="submit" value="<?= __('Sign in') ?>" class="fl"/>
      <a href="#" class="fr toggleForms"><?= __('Forgot password?') ?></a>
    </form>
    <form action="<?= url_for('element/passwordReset') ?>" class="authForm linksWhite" method="post" style="display: none">
      <input type="text" name="user[email]" placeholder="<?= __('Enter email/login') ?>"/>
      <input type="submit" value="<?= __('Send instructions') ?>" class="fl"/>
      <a href="#" class="fr toggleForms"><?= __('Sign in') ?></a>
    </form>
  <?php endif ?>
</div>