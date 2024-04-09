<?php
/*
 * Form Validation (http:// ).
 * Copyright (c) 2024, Charles Anjah
 * All rights reserved.
 * 
 This Class validates all forms including login, registration, messages, and custom forms   
 Add the name of the submitted form to be validated in validateForm() method.
 Date: 08-04-2024
*/

class Validation
{
    function __construct(){
        if(isset($_POST["submitform"])){
            $this->validateForm();
        }
    }

    public $login;
    public $register;
    private $form_data = [];
    public $form_data_err = [];

    /*


    */
    public function validateForm(){
        global $form_data, $form_data_err;
        if (isset($_POST["login"])){
            $this->login =$_POST["login"];
            $this->loginInputChecks();
        }elseif(isset($_POST["register"])){
            $this->register = $_POST["register"];
			$this->registrationInputChecks();
        }
        
    }

    private function loginInputChecks(){
        global $form_data, $form_data_err;
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            // check if any fills in the login request is empty
            if(empty($_POST)){
                $this->form_data_err[] = "One or more field(s) cannot be empty!";
                print_r($this->form_data_err);
            }else{
                
                // check if they contain the required characters
                // 1. login name does not require whitespace and we only need letters
                $form_data["login_name"] = trim($_POST["username"]);
                if (!preg_match("/^[a-zA-Z]*$/", $form_data["login_name"])){
                    $this->form_data_err[] = "Only letters allowed";
                }else{
                    // clean the name data - remove html characters
                    $form_data["login_name"] = $this->cleanFormData($form_data["login_name"]);

                    $form_data["login_pass"] = $_POST["password"];
                    print_r($this->form_data_err);
                    echo $form_data["login_name"]." login successful!<br>";
                    print_r($form_data);
                }
             }
        }
    }

    private function registrationInputChecks(){
        global $form_data, $form_data_err, $form_error_count;
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            // check if any fills in the login request is empty
            if(empty($_POST)){
				foreach($this->form_data_err as $form_error){
					echo $form_error_count = "There are count($form_error) error(s):";
					echo $form_error."<br/>";
				}
            }else{

                // check if they contain the required characters
                // 1. user first name does not require whitespace and we only need letters
                $form_data["user_fname"] = $this->cleanFormData($_POST["firstname"]);
				if (!preg_match("/^[a-zA-Z]*$/", $form_data["user_fname"])){
                    $this->form_data_err["firstname"] = "Only letters allowed";
                }
                // 2. user last name does not require whitespace and we only need letters
                $form_data["user_lname"] = $this->cleanFormData($_POST["lastname"]);
				if (!preg_match("/^[a-zA-Z]*$/", $form_data["user_lname"])){
                    $this->form_data_err["lastname"] = "Only letters allowed";
                }
                // 3. user email does not require whitespace and we only need alphanumeric
                $form_data["user_email"] = $this->cleanFormData($_POST["email"]);
				if (!filter_var($form_data["user_email"], FILTER_VALIDATE_EMAIL)){
                    $this->form_data_err["email"] = "Email is not valid";
                }
                // 4. login name does not require whitespace and we only need letters
                $form_data["login_name"] = $this->cleanFormData($_POST["username"]);
				if (!preg_match("/^[a-zA-Z]*$/", $form_data["login_name"])){
                    $this->form_data_err["username"] = "Only letters allowed for username";
                }
                // 5. login pass does not require whitespace and we only need alphanumeric with symbols
                $pass_result = $this->passwordInputChecker($_POST["password"], $_POST["confirm_password"]);

                // Confirm the number of errors
                if(count($this->form_data_err)> 0){
                    echo "<br>Error on reg form<br>";
                    print_r ($this->form_data_err);
                    return 1; // There are still some errors on the form
                }else{
                    echo "<br> Register success!";
                    return 0; // Success
                }
            }
        }

    }

    private function passwordInputChecker($first_pass, $confirm_pass = ""){
        // set password error array
        $pwd_err = [];
        // Confirm the form name through 
        if(isset($this->login)){
            // Do a few clean up - remove whitespace, etc
            $first_pass = $this->cleanFormData($first_pass);
            // Comfirm the validity of the password

        }
        elseif(isset($this->register)){
            // Clean data
            $first_pass = $this->cleanFormData($first_pass);
            $confirm_pass = $this->cleanFormData($confirm_pass);
            // Set Password rules:
            // First confirm that the confirm password is not empty
            if(empty($first_pass) && empty($confirm_pass)){
                $pwd_err[] = "Password cannot be empty!";
            }elseif(!empty($first_pass)){
                // a. Password must be alphanumeric (lower and uppercase) with special characters
                if(preg_match("/^(.{0,7}|[^0-9]*|[^A-Z]*|[^a-z]*|[a-zA-Z0-9]*)$/", ($first_pass))){
                    $pwd_err[] = "Password MUST contain atleast one special character, one lower, one uppercase, and one number.";
                }
                // // b. Perform a second alphanumeric check (not necessary: only used when the regex above are not properly configured)
                // if(preg_match("/^([0-9a-z])+$/", $first_pass)){
                //     $pwd_err[] = "Password not alphanumeric";
                // }
                // c. Password characters must be more than 8 and less than 20
                if(strlen($first_pass) < 8 || strlen($first_pass) > 20){
                    $pwd_err[] = "Password too short or too long!";
                } 
            }           
            // d. First password and confirm password must be the same - in length, character, and structure
            // First confirm that both passwords are not empty
            elseif(empty($first_pass)){
                $pwd_err[] = "Passwords cannot be empty!";
            }else{
                // Compare the both passwords
                if(strcmp($first_pass,$confirm_pass)!=0){
                    $pwd_err["confirm_password"] = "Password mismatched!";
                }
            }
            // count password errors
            if(count($pwd_err) > 0){
                $error_count = count($pwd_err);
                print_r($pwd_err);
                $this->form_data_err["password"] = "Your password doesn't meet the requirement above: $error_count error(s) found!";
                echo "Password validation NOT successful!";
                return 1; //Password validation NOT successful
            }
            else{
                echo "Password validation successful!";
                return 0; // Password validation successful
            }

        }
    }

    public function cleanFormData($data){
        $data = stripslashes(trim($data));
        $data = htmlspecialchars($data);
        return $data;
    }
}

$validate_form = new Validation;

?>