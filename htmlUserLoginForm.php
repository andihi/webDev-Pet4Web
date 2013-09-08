<form name="logInForm" action="./user.php?section=tryToLogIn" method="post">
	<section>
		<div>
			<label for="email">E-Mail</label>
			<input id="email"type="text" value="" name="email" />
		</div>
		
		<div>
			<label for="password" >Passwort</label>
			<input id="password" type="password" name="password"  />
		</div>
	</section>
	
	<input id="submit" type="submit" value="log in" />
	<a href="user.php?section=createNewUser">Neuen account erstellen...</a>
</form> 