import $ from 'jquery'

class SendProfileInfo{
    constructor(){
        this.btn = document.getElementById('Submit-Profile')
        this.postID = $('#profile-edit-form').data('postid')
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
        
        
        if(this.postID != ""){
            //EDIT THIS TO ADD MORE ITEMS
            
            var accom = []
            $("[name=accomodations]:checked").each( function(){
                accom.push($(this).val())
            })
            

            let parks = []
            $("[name=Parks]:checked").each( function(){
                parks.push($(this).val())
            })
                
                
            let attract = []
            $("[name=Attractions]:checked").each( function(){
                attract.push($(this).val())
            })
            

            let updates = {
                'postID': this.postID,
                'accomodations': accom,
                'parks': parks,
                'attractions': attract,
                'title': $("#comp-name").val(),
                'content': $("#desc").val(),
                'contactFirstName': $(".first-name").val(),
                'contactLastName': $(".last-name").val(),
                'contactEmail': $(".email").val(),
                'status': 'pending'
            }

            console.log(updates)

            //---- JQUERY WAY OF REQUEST CALL MIGHT BE MORE SECURE ----
            $.ajax({
                beforeSend:(xhr) => {
                    xhr.setRequestHeader('X-WP-Nonce', data.nonce);
                },

                url: data.root_url + '/wp-json/neont/v1/profile',
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
        }else{
            console.log("post ID does not exist")
        }    
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