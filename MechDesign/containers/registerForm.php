<div id="registerBox">
    <form method="post" id="registerForm">
        <ul>
            <li>
                <input type="text" id="registerName" name="registerName" />
                <p>Username</p>
            </li>
            <li id="registerNameError" class="registerError"></li>
            <li>
                <input type="text" id="registerEmail" name="registerEmail" />
                <p>Email</p>
            </li>
            <li class="registerError"></li>
            <li>
                <input type="text" id="registerPassword" name="registerPassword" />
                <p>Password</p>
            </li>
            <li id="passwordError" class="registerError"></li>
            <li>
                <input type="text" id="confirmPassword" name="confirmPassword" />
                <p>Confirm Password</p>
            </li>
            <li id="confirmPasswordError" class="registerError"></li>

        </ul>
    </form>
    <input type="submit" class="submitRegistration" name="registerSubmit" value='Register' onclick="checkFormData()" />
    <button class="registerButton2" onclick="clearForm()">Cancel</button>
</div>