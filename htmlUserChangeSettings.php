<script type="text/javascript">
            function checkPassword()
            {
                var password1 = document.getElementById('password1').value;
                var password2 = document.getElementById('password2').value;
        
                document.getElementById("passwordContainer").className = "";                
                
                if(password1 == password2)
                    return true;
                    
                document.getElementById("passwordContainer").className = "wrongInput";
                
                alert('Die eingegebenen Passwörter stimmen nicht überein!');
            
                return false;
        
        
            }
</script>
<form onsubmit="return checkPassword();" id="changeSettingsForm" action="./user.php?section=tryToChangeSettings" method="post">
	<section>		
		<div id="passwordContainer">
			<label for="password1" >Neues Passwort eingeben</label>
			<input id="password1" type="password" name="password1"  />
            <input id="password2" type="password" name="password2"  />
		</div>
	</section>
	
	<input type="submit" value="change settings" id="submit" />
</form> 