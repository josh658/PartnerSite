import $ from 'jquery'

class Login{
    constructor(){
        this.email = $('#login-email')
        this.password = $('#login-password')
        this.btn = $('#login-btn')
        this.form = $('#login-form')
        this.events()
    }
    //for adding event listners or running functions at the start
    events(){
        this.btn.on('click', this.login.bind(this))
    }

    login(e){
        e.preventDefault()

        let update = {
            'email': this.email.val(),
            'password': this.password.val()
        }

        $.ajax({
            url: data.root_url + '/wp-json/neont/v1/login',
            type: 'POST',
            data: update,
            success: (response) => {
                console.log("Congrats")
                console.log(response)
                if(response.message == "OK"){
                    setTimeout(() => {this.form.submit()}, 1000)
                }
            },
            error: (response) => {
                console.log("Error")
                console.log(response)
            }
        })
    }

}

export default Login