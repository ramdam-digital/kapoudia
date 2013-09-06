<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Ramdam Library</title>

    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

    <!-- elFinder JS (REQUIRED) -->
    <script type="text/javascript" src="js/elfinder.min.js"></script>

    <!-- elFinder translation (OPTIONAL) -->
    <script type="text/javascript" src="js/i18n/elfinder.ru.js"></script>

    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce_popup.js"></script>

<script type="text/javascript">

  $().ready(function() {
    var elf = $('#elfinder').elfinder({
      // set your elFinder options here
      url: 'php/connector.php',  // connector URL
      getFileCallback: function(file) { // editor callback
        <?php if(isset($_GET['id'])): ?>
        var image = '<img src="'+file+'" class="img-polaroid" style="width: 64px; height: 64px;"><input type="hidden" class="img-path" name="imgs<?php if(isset($_GET['lang'])) echo '['.$_GET['lang'].']';?>[]" value="'+file+'">';
        window.opener.$("#<?php echo $_GET['id'];?>").prepend(image);
        <?php endif; ?>
        window.close();
        return false;
      }
    }).elfinder('instance');      
  });
</script>
  </head>
  <body>

    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>

  </body>
</html>
