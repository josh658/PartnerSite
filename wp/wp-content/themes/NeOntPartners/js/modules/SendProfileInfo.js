import $ from 'jquery'
import profileDataPull from './functions'

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
        if( window.location.pathname == '/profile-edit/'){
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
        this.lat.value = "locating..."
        this.lng.value = "locating..."
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
        
        profileDataPull(this.postID, 'pending')
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