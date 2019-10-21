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
            success: (response) => {
                console.log(response)
            },
            error: (response) => {
                console.log(response)
            }
        })
    }
}

export default RegistrationForm