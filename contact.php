<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" type="text/css" href="admin/assets/contact.css">
</head>
<main>
  <form method="post" id="contact" action="mailto:example@example.com" enctype="text/plain">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="subject">Subject:</label>
    <input type="text" name="subject" id="subject" required>
    <br>
    <label for="message">Message:</label>
    <textarea name="message" id="message" rows="5" required></textarea>
    <br>
    <input type="submit" value="Submit">
  </form>

</main>
<?php

$to = "muthuigrace64@gmail.com";

// Add mailto link here
echo "<div class='confirmation'>Thank you for contacting us! We will get back to you soon. Or, you can email us directly at <a href='mailto:muthuigrace64@gmail.com'>muthuigrace64@gmail.com</a>.</div>";
?>