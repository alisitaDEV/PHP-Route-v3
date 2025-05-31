<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($title) ?></title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body{
      margin: 0;
      padding: 0;
    }
    
    a {
      color: #09f; 
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div id="app">
    <?= $content ?>
  </div>

  <script>
    $(document).on('click', '.nav-link', function(e) {
      e.preventDefault();
      const url = $(this).attr('href');

      history.pushState(null, '', url);

      $.get('ajax-router.php?spa=true&url=' + url, function(res) {
        if (res.content) {
          $('#app').html(res.content);
          document.title = res.title;
        } else {
          $('#app').html('<p>Error loading page</p>');
        }
      }, 'json');
    });

    // Handle back/forward button
    window.onpopstate = function() {
      const path = location.pathname.replace(/^\/+|\/+$/g, '');
      $.get('ajax-router.php?spa=true&url=' + path, function(res) {
        $('#app').html(res.content);
        document.title = res.title;
      }, 'json');
    };
  </script>
</body>
</html>