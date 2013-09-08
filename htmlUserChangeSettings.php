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