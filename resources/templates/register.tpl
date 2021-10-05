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
    <label for="username">User name</label>
    <input type="text" id="username" class="form-control"  name="name"   value="{old('name')}">
  </div>
 
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" id="email" class="form-control"  name="email"   value="{old('email')}">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" class="form-control"  name="password">
  </div>
   <div class="form-group">
    <label for="passwordconfirm">Confirm password</label>
    <input type="password" id="passwordconfirm" class="form-control"  name="password_confirm">
  </div>

   <div class="form-group">
  <select class="form-select form-control form-select-lg" id="typeselect" name="user-type" required>
  <option value='' selected>Select user type</option>
  {foreach from=$types  item=type}
  <option value={$type['value']}>{$type['name']}</option>
  {/foreach}
</select>
</div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div class="d-block text-danger">
{errors()}
</div>
</div>

</body>
</html>