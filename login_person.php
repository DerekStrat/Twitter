<?php

class LogIn {
    public string $FirstNameStr;
    public string $LastNameStr;
    public string $UserNameStr;
    public string $EmailAddressStr;
    public string $PasswordStr;

    public string $SavedUserStr;
    public string $SavedPasswordStr;

    private $ConnectionObj;

    /**
     * Checks if query to DB was success/error
     */
    function checkQuery($QueryStr) { 
        if ($this->ConnectionObj->query($QueryStr) === TRUE) {
            echo "Success<br>";
            } else {
            echo "Error: " . "<br>" . $this->ConnectionObj->error;
            }
    }

    /**
     * Create connection to DB 'php_exercise', table 'users'
     */
    function createConn() {
        $this->ConnectionObj = new mysqli("localhost", "root", "", "php_exercise");
        if ($this->ConnectionObj->connect_error) {
            die("Connection failed: " . $this->ConnectionObj->connect_error);
        }
    }

    /** 
     * End the connection to DB 'php_exercise', table 'users'
     */
    function endConn() {
        $this->ConnectionObj->close();
    }

    // login
    function checkUserExists($UserStr) { // security
        $IdInt = 0;
        $MyPasswordStr = "";
        $ReturnStr = "";
        $this->createConn();

        // prepare and bind
        $PrepObj = $this->ConnectionObj->prepare("SELECT ID, Password FROM users WHERE Username=?");
        $PrepObj->bind_param("s", $UserStr);
        // execute
        $PrepObj->execute();
        // Store the result so we can check if the account exists in the database.
        $PrepObj->store_result();

        if ($PrepObj->num_rows > 0) {
            $PrepObj->bind_result($IdInt, $MyPasswordStr); // require hashed password from DB!
            $PrepObj->fetch();
            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords.
            if (password_verify($this->SavedPasswordStr, $MyPasswordStr)) {
                // Verification success! User has logged-in!
                // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $UserStr;
                $_SESSION['id'] = $IdInt;
                // Success
                $ReturnStr = "Successful";
            } else {
                // Incorrect password
                $ReturnStr = "passErr";
            }
        } else {
            // Incorrect username
            $ReturnStr = "userErr";
        }

        $this->endConn();

        return $ReturnStr;
    }

    function checkEmailExists($EmailStr) { // security
        $IdInt = 0;
        $MyPasswordStr = "";
        $ReturnStr = "";
        $this->createConn();

        // prepare and bind
        $PrepObj = $this->ConnectionObj->prepare("SELECT ID, Password FROM users WHERE EmailAddress=?");
        $PrepObj->bind_param("s", $EmailStr);
        // execute
        $PrepObj->execute();
        // Store the result so we can check if the account exists in the database.
        $PrepObj->store_result();

        if ($PrepObj->num_rows > 0) {
            $PrepObj->bind_result($IdInt, $MyPasswordStr);
            $PrepObj->fetch();
            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords.
            if (password_verify($this->SavedPasswordStr, $MyPasswordStr)) {
                // Verification success! User has logged-in!
                // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $EmailStr;
                $_SESSION['id'] = $MyPasswordStr;
                // Success
                $ReturnStr = "Successful";
                header('Location: home.php');
            } else {
                // Incorrect password
                $ReturnStr = "passErr";
            }
        } else {
            // Incorrect username
            $ReturnStr = "userErr";
        }

        $this->endConn();

        return $ReturnStr;
    }

    function checkLogin($UsernameStr, $PassStr) {
        $UserStr = trim($UsernameStr);
        $this->SavedPasswordStr = trim($PassStr);

        $ResultStr = $this->checkUserExists($UserStr);
        if ($ResultStr != "userErr") {
            return $ResultStr;
        } else {
            $ResultStr = $this->checkEmailExists($UserStr);
            if ($ResultStr != "userErr") {
                return $ResultStr;
            } else {
                return "userErr";
            }
        }
    }



    ///////////////// sign up /////////////////////
    function validateUsername($UserStr) {
        if ($UserStr == " " || $UserStr == "") {
            return true;
        } else {
            $UserStringArr = str_split($UserStr);
            if (count($UserStringArr) > 100) {
                return true;
            } else {
                return false;
            }
        }
    }

    // sign up
    function testPassword($PasswordStr) {
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $PasswordStr);
        $lowercase = preg_match('@[a-z]@', $PasswordStr);
        $number    = preg_match('@[0-9]@', $PasswordStr);
        $specialChars = preg_match('@[^\w]@', $PasswordStr);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($PasswordStr) < 8) {
            return true;
        } else {
            return false;
        }
    }

    function validateEmail($EmailStr) {
        if (filter_var($EmailStr, FILTER_VALIDATE_EMAIL)) {
            $atPos = mb_strpos($EmailStr, '@');
            // Select the domain
            $DomainStr = mb_substr($EmailStr, $atPos + 1);
            if (checkdnsrr($DomainStr . '.', 'MX')) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    function correctName($NameStr) {
        $NameStr = strtolower($NameStr);
        $NameStr = ucfirst($NameStr);
        return $NameStr;
    }

    function checkSignUpFields() {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $this->FirstNameStr) || $this->FirstNameStr == "" || $this->FirstNameStr == " ") {
            return "nameErr";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $this->LastNameStr) || $this->LastNameStr == "" || $this->LastNameStr == " ") {
            return "surnameErr";
        } elseif ($this->validateEmail($this->EmailAddressStr)) {
            return "emailErr";
        } elseif ($this->checkEmailExists($this->EmailAddressStr)) {
            return "This E-mail is already in use.";
        } elseif ($this->checkUserExists($this->UserNameStr)) {
            return "This username already exists.";
        } elseif ($this->validateUsername($this->UserNameStr)) {
            return "userErr";
        } elseif ($this->testPassword($this->PasswordStr)) {
            return "passErr";
        } else {
            $this->FirstNameStr = $this->correctName($this->FirstNameStr);
            $this->LastNameStr = $this->correctName($this->LastNameStr);
            return "none";
        }
    }

    function checkSignUp($FNameStr, $LNameStr, $EmailStr, $UserStr, $PassStr) {
        $this->FirstNameStr = trim($FNameStr);
        $this->LastNameStr = trim($LNameStr);
        $this->EmailAddressStr = strtolower($EmailStr);
        $this->UserNameStr = trim($UserStr);
        $this->PasswordStr = trim($PassStr);

        $ResultStr = $this->checkSignUpFields();

        if ($ResultStr != "none") {
            return $ResultStr;
        } else {
            $this->createConn();

            // insert
            $SignUpStr = "INSERT INTO users (FirstName, LastName, EmailAddress, Username, Password)
                VALUES ('".$this->FirstNameStr."', '".$this->LastNameStr."', '".$this->EmailAddressStr."', '".$this->UserNameStr."', '".$this->PasswordStr."')";
            $this->ConnectionObj->query($SignUpStr);

            $this->endConn();
            return 1;
        }
    }
}

?>