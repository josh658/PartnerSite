//import $ from 'jquery'

class SendProfileInfo{
    constructor(){
        this.btn = document.getElementById('Submit-Profile')
        this.events();
    }

    events(){
        this.btn.addEventListener("click", this.updateProfile.bind(this))
    }

    //methods
    updateProfile(){
        
        var httpRequest = new XMLHttpRequest();

        //EDIT THIS TO ADD MORE ITEMS
        var updates = {
            'title': document.getElementById('comp-name').value,
            'content': document.getElementById('desc').value,
            'contactFirstName': document.getElementById('first-name').value,
            'contactLastName': document.getElementById('last-name').value,
            'contactEmail': document.getElementById('email').value
            
            /*
                'title': $("#comp-name").val(),
                'content': $("#desc").val(),
                'contactFirstName': $("first-name").val(),
                'contactLastName': $("last-name").val(),
                'contactemail': $("email").val()
            */
        }

        /*
        ---- JQUERY WAY OF REQUEST CALL MIGHT BE MORE SECURE ----
        $.ajax({
            beforeSend:(xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', data.nonce);
            },

            url: 'http://localhost:3000/wp-json/wp/v2/partners/' + document.getElementById('profile-edit-form').dataset.postid,
            type:'POST',
            data: updates,
            success: (response) => {
                console.log("Congrats")
                console.log(response)
            },
            error: (response) => {
                console.log("Error")
                console.log(response)
            }
        })
        */

        if(!httpRequest){
            alert('ERROR: Cannot create an XMLHTTP instnace')
            return false
        }

        httpRequest.onreadystatechange = alertContents;
        httpRequest.open('POST', 'http://localhost:3000/wp-json/wp/v2/partners/' + document.getElementById('profile-edit-form').dataset.postid, true)
        httpRequest.setRequestHeader('X-WP-Nonce', data.nonce )
        httpRequest.setRequestHeader('Content-Type', 'application/json')
        httpRequest.send(JSON.stringify(updates))
        //httpRequest.send()

        function alertContents(){
            try{
                if(httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200){
                    console.log(httpRequest.responseText)
                } else {
                    console.log("not working")
                    //console.log(httpRequest.responseText + " readyState: " + httpRequest.readyState + " status: " + httpRequest.status)
                }
            }
            catch(e){
                alert('CaughtException: ' + e.description)
            }
        }
        
    }
}
export default SendProfileInfo