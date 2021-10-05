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