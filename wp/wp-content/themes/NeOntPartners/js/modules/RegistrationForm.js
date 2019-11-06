import $ from 'jquery'

class RegistrationForm{
    constructor(){
        $('#error-message').hide()
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
            url: data.root_url + '/wp-json/neont/v1/register',
            type: 'POST',
            data: formValues,
            //register-route deals with this success
            success: (response) => {
                console.log("sucess")
                console.log(response)
                if(response.message != 'OK'){
                    $('#error-message').html(response.message)
                    $('#error-message').show("slow")
                } else {
                    window.location.replace(data.root_url + "/profile-edit")
                    alert("welcome new memeber")
                }
            },
            error: (response) => {
                console.log("error: " + data.userId)
                console.log(response)
            }
        })
    }
}

export default RegistrationForm