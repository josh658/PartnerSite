<?php
    //pulling in header
    get_header();
?>
<main>
    <h3 class="profile-header">Your Profile</h3>
    <div class="twoColumns">
        <!--left side-->
        
        <div class="packages">
            <h4>Packages</h4>
            <ul>
            
            </ul>
            <!-- pull in information about packages -->
        </div>
        <!-- right Side-->
        <form class="profile-edit-form" action="" method="post">
            <div class="container">
            <h4 class="heading">Information</h4>
            <input class="input comp-name" type="textbox" placeholder="Company Name" >
            <h4 class="headeing">description</h4>
            <input class="input desc" type="textarea" placeholder="Description of your company">
            <h4 class="heading">contanct info</h4>
            <div class=" input name">
                <input class="input first-name" type="textbox" placeholder="First Name">
                <input class="input last-name" type="textbox" placeholder="Last Name">
            </div>
            <input class="input email" type="textbox" placeholder="Email">
            
            <!-- content of the form -->
        </form>
    </div>
<!-- Place hetml for form here-->
</main>

<?php      
    get_footer();
?>