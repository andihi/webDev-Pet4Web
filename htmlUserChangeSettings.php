
<script type="text/javascript">
    function checkPassword()
    {
        var password1 = document.getElementById('password1');
        var password2 = document.getElementById('password2');
        
        if(password1 != password2)
        {
            document.getElementById("passwordContainer").className = "wrongInput";
            alert('Die eingegebenen Passwörter stimmen nicht überein!');
            
            return false;
        }
    }
</script>
<form name="logInForm" action="./user.php?section=tryToChangeSettings" method="post">
	<section>		
		<div id="passwordContainer">
			<label for="password" >Neues Passwort eingeben</label>
			<input id="password1" type="password" name="password"  />
            <input id="password2" type="password" name="password"  />
		</div>
	</section>
	
	<input type="submit" value=" change settings " onclick="checkPassword()" />
</form> 