<form method="POST" action="{route('loginpost')}">
{csrf()}
<div class="form-group">
<label for="email">Email:</label>
<input type="text" class="form-control" id="email" name="email" value='{old('email')}' required>
</div>
<div class="form-group">
<label for="password">Password:</label>
<input type="password" class="form-control" id="password" name="password" required>
</div>
<button class="btn btn-light" type="submit">LogIn</button>
</form>