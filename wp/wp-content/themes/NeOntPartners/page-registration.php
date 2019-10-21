<?php
    //pulling in header
    get_header();
?>
<main>
<?php
    
?>
<form id="register-form">
    <label>First Name</label>
    <input id="first-name" placeholder="First Name" >
    <label for="">Last Name</label>
    <input id="last-name" placeholder="Last Name">
    <label >Password</label>
    <input id="password" type="password">
    <label >Email</label>
    <input id="email" type="email">
    <input type="submit" name="register" id="register-btn">
</form>

<!-- add registration react app here -->
</main>

<?php        
    get_footer();
?>