<html>
<head>
<title>{$appname}-Login</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">{$appname}</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="{route('home')}">Home <span class="sr-only">(current)</span></a>
    </div>
  </div>
</nav>
<div class="container">
<form method="POST" action="{route('loginpost')}">
{csrf()}
<div class="form-group">
<label for="email">Email:</label>
<input type="text" id="email" name="email" value='{old('email')}' required>
</div>
<div class="form-group">
<label for="password">Password:</label>
<input type="password" id="password" name="password" required>
</div>
<button type="submit">LogIn</button>
</form>
</div>
</body>
</html>