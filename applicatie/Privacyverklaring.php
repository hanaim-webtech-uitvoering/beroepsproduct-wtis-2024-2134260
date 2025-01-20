<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Privacyverklaring</title>
</head>

<body>
  <nav>
    <ul>
      <li><a href="menu.php">Menu</a></li>
      <li><a href="shoppingCart.php">Winkelmandje</a></li>
      <li><a href="profile.php">Profiel</a></li>
      <?php if ($_SESSION['role'] == 'Personnel'): ?>
        <li><a href="orderOverview.php">bestelling overzicht</a></li>
        <li><a href="detailOverview.php">Detail overzicht</a></li>
      <?php endif; ?>
      <li><a href="privacyverklaring.php">Privacyverklaring</a></li>
    </ul>
  </nav>
  <h1> Privacyverklaring </h1>
  <p>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquam tristique feugiat. Sed rhoncus imperdiet
    nisl. Praesent faucibus elementum risus eleifend imperdiet. Sed eget pellentesque orci, a rutrum mauris. Phasellus
    id varius ex. Nulla vehicula volutpat lorem vitae congue. Quisque quis tristique elit, ut tempus nulla. Sed bibendum
    pulvinar ultricies. Nulla et lectus lobortis, sagittis mauris eget, tristique justo. Vestibulum sollicitudin nibh
    nec accumsan facilisis. Maecenas sollicitudin lectus enim, at gravida enim vehicula et. Suspendisse eget arcu ac
    turpis hendrerit viverra vitae nec felis. Praesent nec nibh sem.

    Donec risus ligula, porttitor vitae fermentum ut, pulvinar in risus. Cras cursus aliquam eros. Quisque metus nulla,
    egestas in tristique id, ultricies ac arcu. Curabitur justo nulla, efficitur vitae bibendum non, molestie eget elit.
    Nulla mollis urna nec nisi placerat, sed elementum augue convallis. Nunc condimentum est massa, vel aliquet arcu
    vestibulum ac. Morbi convallis sem id lectus pulvinar tristique. Aenean cursus consequat justo eget sagittis.

    Aliquam condimentum pulvinar magna, in tincidunt tellus tristique sit amet. Donec ligula nibh, ultricies eu orci
    vel, venenatis blandit elit. Curabitur vehicula augue eros, eu pellentesque sem venenatis vitae. Aenean vehicula
    mauris nibh, sed tincidunt erat tempor non. Proin sit amet sollicitudin urna. Etiam molestie purus at dolor
    scelerisque efficitur. Maecenas vitae tellus malesuada, maximus nunc a, ullamcorper libero. Curabitur venenatis,
    metus ac tristique dapibus, nisi dolor volutpat neque, sit amet volutpat orci turpis a erat. Praesent vestibulum
    neque ante, eu egestas ante fermentum non.

    Donec sollicitudin tellus sit amet massa pulvinar, non sagittis turpis pretium. Aliquam in porta orci, quis
    tincidunt eros. Donec at nunc leo. Quisque semper, quam a ullamcorper fringilla, tellus enim venenatis lectus, sit
    amet blandit dui odio ac justo. Aliquam mollis pulvinar tortor eu dignissim. Cras quis convallis tortor. Maecenas
    vitae sollicitudin lorem. Morbi velit odio, venenatis quis pulvinar lacinia, sollicitudin porttitor leo. Nulla in
    tortor aliquet, condimentum ligula id, suscipit nibh. Morbi ornare non quam eu porttitor. Sed viverra venenatis
    dolor a sagittis. Fusce risus mi, volutpat ac magna sed, dictum dignissim diam.

    Morbi at erat eu nisl varius accumsan. Nam augue nisl, congue vitae augue ac, feugiat blandit augue. Ut eget nisi
    tempor, tincidunt nunc sed, volutpat massa. Morbi non elit consequat, consequat diam a, vulputate quam. Suspendisse
    pretium maximus libero, sit amet pulvinar felis fringilla sed. In ac consequat enim. Maecenas euismod justo non
    maximus accumsan.
  </p>
</body>

</html>