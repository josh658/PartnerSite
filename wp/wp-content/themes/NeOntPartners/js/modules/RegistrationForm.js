import $ from 'jquery'

class RegistrationForm{
    constructor(){
        //this. passwordError = $('#pasword-error')
        this.password = $('#password')
        this.email = $("#email")
        this.passwordErrorDisplay = $('.password-error-message')
        this.emailErrorDisplay = $('.email-error-message')
        this.form = $("#register-form")
        $('#error-message').hide()
        this.events()
    }

    //events
    events(){
        $("#register-btn").on("click", this.clickListner.bind(this))
        $('.card-sub-select').on('click', this.subSelect) 
        this.form.on('keypress', this.enter.bind(this))
    }
    //methods

    enter(e){
        console.log(e.keyCode)
        if(e.keyCode == 13){
            e.preventDefault()
            // **remove the below comment to have enter submit the form
            // this.clickListner.call(this, event)
        }
    }

    clickListner(e){
        e.preventDefault()

        //check if the password has all required criteris
        if(this.password.val() != ""){
            let errorMessage = []
            if(!/[a-z]/.test(this.password.val())){
                errorMessage.push("password must have at least one lowercase letter")
            }
            if(!/[A-Z]/.test(this.password.val())){
                errorMessage.push("password must have at least one uppercase letter")
            }
            if(!/\d/.test(this.password.val())){
                errorMessage.push("password must contain at least one number")
            }
            if(!/\w{8,}/.test(this.password.val())){
                errorMessage.push("password must be longet then 8 charcters")
            }
            if(/\W/.test(this.password.val())){
                errorMessage.push("Password cannot contain any special charaters")
            }
            //pass word cannot be username/email
            if(this.password.val() == this.email.val()){
                errorMessage.push("Password cannot be your email")
            }
            //alert(errorMessage.length)
            if(errorMessage.length){
                // clear innerHTML 
                this.passwordErrorDisplay.html("")
                for (const error of errorMessage){
                    //insert innerHTML
                    this.passwordErrorDisplay.append("<p>" + error + "</p>")
                }
                return
            }
        } else {
            this.passwordErrorDisplay.html("Empty Password")
            return
        }

        //don't allow submission if email is not correct
        this.emailErrorDisplay.html()
        if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/.test(this.email.val())){
            this.emailErrorDisplay.html('Invalid Email')
            return
        }

        //if a value is changed here it must be changed in register.route
        var formValues = {
            'FirstName': $("#first-name").val(),
            'LastName': $("#last-name").val(),
            'Password': this.password.val(),
            'email': this.email.val(),
            'package': $('.card-selected').data('subID')
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
                }
            },
            error: (response) => {
                console.log("error: " + data.userId)
                console.log(response)
            }
        })
    }

    subSelect(e){
        e.preventDefault()
        $('.card-selected').removeClass('card-selected')
        $(this).parent('div').addClass('card-selected')
    }
}

export default RegistrationForm