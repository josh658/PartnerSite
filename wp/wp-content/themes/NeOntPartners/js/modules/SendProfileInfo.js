import $ from 'jquery'
import profileDataPull from './Functions/profileDataPull'
import imgUpload from'./Functions/imgUpload'

class SendProfileInfo{
    constructor(){
        //disable all input if data-status id pending.
        if($('#top-pending-message').attr('data-status') == 'pending'){
            $("input, textarea").prop('disabled', true)
            
        }
        this.switchDraft = $('#switch-draft-top-btn')
        this.editable = $('#top-pending-message').attr('data-status') == 'pending' ? false : true
        this.dropArea = $('#drop-area')
        this.autosaveBtn = $('#auto-save-btn')
        this.btn = document.getElementById('submit-profile-btn')
        this.postID = $('#profile-edit-form').data('postid')
        this.moreInfo = $(':checkbox')
        this.locate = document.getElementById('locate')
        this.lat = document.getElementById('lat')
        this.lng = document.getElementById('lng')
        this.same = document.getElementById('same-as-location')
        this.sameContent = document.getElementById('same-as-location-content')
        this.saveBtn = $('#save-profile-btn')
        this.typingTime;

    }

    events(){
        imgUpload(this.dropArea)
        // add switchToDraft so you can switch to draft
        // look at getting this editable mode on the go
        this.switchDraft.on('click', this.switchToDraft)
        this.saveBtn.on('click', this.updateProfile.bind(this.moreInfo, this.postID, 'draft'), false)
        this.same.addEventListener("click", this.sameAs.bind(this), false)
        this.locate.addEventListener("click", this.locating.bind(this), false)
        this.btn.addEventListener("click", this.updateProfile.bind(this.moreInfo, this.postID, 'pending'), false)
        document.addEventListener('keyup', this.btnEnable.bind(this), false)
        //save a second after a key is presses
        document.addEventListener('keyup', this.typingLogic.bind(this), false)
        this.moreInfo.on('change', this.updateProfile.bind(this.moreInfo, this.postID, 'draft'), false)
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
    updateProfile(postID, status){
        profileDataPull.call(this, postID, status)
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