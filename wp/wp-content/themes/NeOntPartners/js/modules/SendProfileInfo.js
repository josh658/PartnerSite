import $ from 'jquery'

class SendProfileInfo{
    constructor(){
        this.btn = document.getElementById('Submit-Profile')
        if(this.btn){
            this.events();    
        }
    }

    events(){
        this.btn.addEventListener("click", this.updateProfile.bind(this))
        document.addEventListener('keyup', this.btnEnable.bind(this))
    }

    //methods
    updateProfile(){
        
        //var httpRequest = new XMLHttpRequest();

        //EDIT THIS TO ADD MORE ITEMS
        var updates = {
            // 'title': document.getElementById('comp-name').value,
            // 'content': document.getElementById('desc').value,
            // 'contactFirstName': document.getElementById('first-name').value,
            // 'contactLastName': document.getElementById('last-name').value,
            // 'contactEmail': document.getElementById('email').value
            
            'title': $("#comp-name").val(),
            'content': $("#desc").val(),
            'contactFirstName': $(".first-name").val(),
            'contactLastName': $(".last-name").val(),
            'contactEmail': $(".email").val(),
            'status': 'pending'
        }


        //---- JQUERY WAY OF REQUEST CALL MIGHT BE MORE SECURE ----
        $.ajax({
            beforeSend:(xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', data.nonce);
            },

            url: data.root_url + '/wp-json/neont/v1/register' + document.getElementById('profile-edit-form').dataset.postid,
            type:'POST',
            data: updates,
            success: (response) => {
                console.log("Congrats")
                console.log(updates)
                console.log(response)
            },
            error: (response) => {
                console.log("Error")
                console.log(response)
            }
        })        
    }

    btnEnable(){
        if(document.getElementsByClassName('char-cap').length){
            this.btn.disabled = true
        } else {
            this.btn.disabled = false
        }
    }
}
export default SendProfileInfo