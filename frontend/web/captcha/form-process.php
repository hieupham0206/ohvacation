<?php

session_start();
$errorMSG  = "";
$name      = $_POST["name"];
$job       = $_POST["job"];
$email     = $_POST["email"];
$phone     = $_POST["phone"];
$company   = $_POST["company"];
$employees = $_POST["employees"];
$products  = $_POST["products"];
$message   = $_POST["message"];
if (empty($_SESSION['6_letters_code']) ||
    strcasecmp($_SESSION['6_letters_code'], $_POST['capchar_test']) != 0
) {
    $errorMSG .= "\n The captcha code does not match!";
}

$EmailTo = "emailaddress@test.com";
$Subject = "New Message Received";

// prepare email body text
$Body = "";
$Body .= "Name: ";
$Body .= $name;
$Body .= "\n";
$Body .= "Job: ";
$Body .= $job;
$Body .= "\n";
$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";
$Body .= "Phone: ";
$Body .= $phone;
$Body .= "\n";
$Body .= "Company: ";
$Body .= $company;
$Body .= "\n";
$Body .= "Employees: ";
$Body .= $employees;
$Body .= "\n";
$Body .= "Products: ";
$Body .= $products;
$Body .= "\n";
$Body .= "Question: ";
$Body .= $message;
$Body .= "\n";

// send email
$success = mail($EmailTo, $Subject, $Body, "From:" . $email);

// redirect to success page
if ($success && $errorMSG == "") {
    echo "success";

} else {
    if ($errorMSG == "") {
        echo "Something went wrong :(";
    } else {
        echo $errorMSG;
    }
}

?>