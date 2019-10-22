import $ from 'jquery'

class RegistrationForm{
    constructor(){
        this.events()
    }

    //events
    events(){
        $("#register-btn").on("click", this.clickListner.bind(this))
    }
    //methods
    clickListner(e){
        e.preventDefault()

        //if a value is changed here it must be changed in register.route
        var formValues = {
            'FirstName': $("#first-name").val(),
            'LastName': $("#last-name").val(),
            'Password': $("#password").val(),
            'email': $("#email").val()
        }

        $.ajax({
            url: 'http://localhost:3000/wp-json/neont/v1/register',
            type: 'POST',
            data: formValues,
            success: () => {
                console.log("success")
                location.reload()
                // DONE: this will fail FIX this!!!!
                //setTimeout( () => location.reload(), 1000) **fixed with returning in register-route.php
            },
            error: (response) => {
                console.log(response)
            }
        })
    }
}

export default RegistrationForm