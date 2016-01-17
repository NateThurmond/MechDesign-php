
<script>
    function checkFormData() {
        
        var newUserName = document.forms["registerForm"]["registerName"].value;
        var newUserEmail = document.forms["registerForm"]["registerEmail"].value;
        var newRegisterPassword = document.forms["registerForm"]["registerPassword"].value;
        var newConfirmPassword = document.forms["registerForm"]["confirmPassword"].value;

            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
               xmlhttp=new XMLHttpRequest();
             }
             xmlhttp.onreadystatechange=function() {
               if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                 document.getElementById("registerBox").innerHTML=xmlhttp.responseText;
               }
             }
             xmlhttp.open("POST","php/register.php?name="+newUserName+"&pass="+newRegisterPassword+"&confirmPass="+newConfirmPassword+"&email="+newUserEmail,true);
             xmlhttp.send();
    }
    
    function clearForm() {

        $( "#registerBox" ).fadeToggle( "slow");
        
        $('input[type=text]').each(function(){
          $('#registerName').val('');
          $('#myusername').val('');
          $('#registerEmail').val('');
          $('#registerPassword').val('');
          $('#mypassword').val('');
          $('#confirmPassword').val('');
          $('.registerError').empty();
      
    });
    }
</script>

<div id="registerBox" >
    <form method="post" id="registerForm">
        <ul>
            <li>
                <input type="text" id="registerName" name="registerName"/> <p>Username</p>         
            </li>
            <li id="registerNameError" class="registerError"></li>
            <li>
                <input type="text" id="registerEmail" name="registerEmail" /> <p>Email</p>         
            </li>
            <li class="registerError"></li>
            <li>
                <input type="text" id="registerPassword" name="registerPassword" /> <p>Password</p>         
            </li>
            <li id="passwordError" class="registerError"></li>
            <li>
                <input type="text" id="confirmPassword" name="confirmPassword" /> <p>Confirm Password</p>         
            </li>
            <li id="confirmPasswordError" class="registerError"></li>
            
        </ul>
    </form>
        <input type="submit" class="submitRegistration" name="registerSubmit" value='Register' onclick="checkFormData()"/>
        <button class="registerButton2" onclick="clearForm()">Cancel</button>
</div>