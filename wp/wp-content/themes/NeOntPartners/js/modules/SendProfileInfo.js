import $ from 'jquery'

class SendProfileInfo{
    constructor(){
        this.btn = document.getElementById('Submit-Profile')
        this.postID = $('#profile-edit-form').data('postid')
        this.moreInfo = document.getElementById('more-info')
        this.locate = document.getElementById('locate')
        this.lat = document.getElementById('lat')
        this.lng = document.getElementById('lng')
        this.same = document.getElementById('same-as-location')
        this.sameContent = document.getElementById('same-as-location-content')
        this.typingTime;
        if( this.postID != null){
            this.events();  
        }
    }

    events(){
        this.same.addEventListener("click", this.sameAs.bind(this))
        this.locate.addEventListener("click", this.locating.bind(this))
        this.btn.addEventListener("click", this.updateProfile.bind(this))
        document.addEventListener('keyup', this.btnEnable.bind(this))
        //save a second after a key is presses
        document.addEventListener('keyup', this.typingLogic.bind(this))
        this.moreInfo.addEventListener('click', this.updateProfile.bind(this))

    }

    sameAs(){
        //this does not check if somehting is checked
        //make this more future proof
        if(this.same.checked == true){
                this.sameContent.style.display = "block"
        } else {
                this.sameContent.style.display = "none"
        }
        console.log(document.getElementById('same-as-location').checked)
    }

    locating(){
        function success(position){
            this.lat.value = position.coords.latitude
            this.lng.value = position.coords.longitude
            this.updateProfile()
        }

        function error(){
        }

        if(!navigator.geolocation){
            //status.textContent = 'Geolocation is not supported by your browser'
        } else {
            //must bing success or else it will have the wrong values
            navigator.geolocation.getCurrentPosition(success.bind(this), error)
        }
    }

    typingLogic(){
        clearTimeout(this.typingLogic)
        this.typingLogic = setTimeout(this.updateProfile.bind(this), 1000)
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
            $("[name=camping]:checked").each( function(){
                parks.push($(this).val())
            })
                
                
            let attract = []
            $("[name=attractions]:checked").each( function(){
                attract.push($(this).val())
            })
            

            let updates = {
                //acf will be an array made to loop through
                'acfCheckbox': {
                    'accomodations': accom,
                    'parks': parks,
                    'attractions': attract,
                    
                },
                'acfString': {
                    'secondary_contact_firstname': $("#s-first-name").val(),
                    'secondary_contact_lastname': $("#s-last-name").val(),
                    'secondary_contact_email': $("#s-email").val() ,
                    'website_url' : $("#website").val(),
                    'business_email': $("#business-email").val(),
                    'business_street_address': $("#business-addr").val(),
                    'business_city': $("#b-city").val(),
                    'business_postal_code': $("#b-postal-code").val(),
                    'latitude': $("#lat").val(),
                    'longitude': $("#lng").val(),
                    'business_phone_number': $("#b-phonenumber").val(),
                    'toll_free_number': $("#toll-free").val(),
                    'head_office_street_address': $("#head-addr").val(),
                    'head_office_city': $("#head-city").val(),
                    'head_office_provincestate': $("#head-province").val(),
                    'head_office_postal_code': $("#head-postal").val(),
                    'head_office_phone_number': $("#head-phone").val()
                },
                'postID': this.postID,
                'title': $("#comp-name").val(),
                'content': $("#desc").val(),
                'status': 'pending',
                //contact 1 information is saved directly to user
                'contactFirstName': $("#first-name").val(),
                'contactLastName': $("#last-name").val(),
                'contactEmail': $("#email").val(),
            }

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