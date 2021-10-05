<html>
<head>
<title>{$appname}-Register</title>
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
<form method="POST" action="{route('registerpost')}">
{csrf()}
  <div class="form-group">
    <label for="exampleInputEmail1">User name</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="" value="{old('name')}">
  </div>
 
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="" value="{old('email')}">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="">
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Confirm password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password_confirm" placeholder="">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div class="d-block text-danger">
{errors()}
</div>
</div>

</body>
</html>