import $ from 'jquery'
import profileDataPull from './Functions/profileDataPull'

class SendProfileInfo{
    constructor(){
        this.dropArea = $('#drop-area')
        this.autosaveBtn = $('#auto-save-btn')
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
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            this.dropArea.on(eventName, this.preventDefault)
        });
        ['dragenter', 'dragover'].forEach(eventName => {
            this.dropArea.on(eventName, this.highlight.bind(this))
        });
        ['dragleave', 'drop'].forEach(eventName => {
            this.dropArea.on(eventName, this.unhighlight.bind(this))
        });
        this.dropArea.on('drop', this.handleDrop.bind(this))
        this.same.addEventListener("click", this.sameAs.bind(this))
        this.locate.addEventListener("click", this.locating.bind(this))
        this.btn.addEventListener("click", this.updateProfile.bind(this.moreInfo, this.postID))
        document.addEventListener('keyup', this.btnEnable.bind(this))
        //save a second after a key is presses
        document.addEventListener('keyup', this.typingLogic.bind(this))
        this.moreInfo.addEventListener('click', this.updateProfile.bind(this.moreInfo, this.postID))

    }

    preventDefault(e){
        e.preventDefault()
        e.stopPropagation()
    }

    highlight(){
        this.dropArea.addClass('highlight')
    }

    unhighlight(){
        this.dropArea.removeClass('highlight')
    }

    handleDrop(e){
        let dt = e.dataTransfer
        let files = dt.files

        this.handleFiles(files)
    }

    handleFiles(files){
        ([...files]).forEach(this.uploadFile)
    }

    uploadFile(file){
        
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

    locating(e){
        this.lat.value = "locating..."
        this.lng.value = "locating..."
        function success(position){
            this.lat.value = position.coords.latitude
            this.lng.value = position.coords.longitude
            profileDataPull.call(e.target, this.post, 'draft')
        }

        function error(){
            this.lat.value = "location unavailable"
            this.lng.value = "location unavailable"
        }

        if(!navigator.geolocation){
            //status.textContent = 'Geolocation is not supported by your browser'
        } else {
            //must bing success or else it will have the wrong values
            navigator.geolocation.getCurrentPosition(success.bind(this), error.bind(this))
        }
    }

    typingLogic(e){
        //alert(this.autosaveBtn.prop('checked'))
        if (this.autosaveBtn.prop('checked')){
            clearTimeout(this.typingLogic)
            this.typingLogic = setTimeout(profileDataPull.bind(e.target, this.postID, 'draft'), 1500)
        }
    }

    //methods
    updateProfile(postID){
        profileDataPull.call(this, postID, 'pending')
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