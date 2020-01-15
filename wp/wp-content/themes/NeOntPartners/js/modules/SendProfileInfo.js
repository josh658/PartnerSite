import $ from 'jquery'
import profileDataPull from './Functions/profileDataPull'
import imgUpload from'./Functions/imgUpload'
import requiredCheck from './Functions/requiredCheck'
import pullAddOn from './Functions/pullAddOn'
import addProductToCart from './Functions/addToCart'

class SendProfileInfo{
    constructor(){
        //disable all input if data-status id pending.

        if( window.location.pathname == '/profile-edit/'){
            this.addToCart = $('.add-to-cart')

            this.addOnTitle = $('#digital-add-on-title')
            this.addOnDescription = $('#digital-add-on-description')
            this.addOnButton = $('#digital-add-to-cart')
            this.digitalAddOn = $('.add-on')

            this.adnav = $('.ad-nav--item')
            this.adCard = $('.ad-card')
            this.adCard.hide()
            $('#package').show()
            
            this.subnav = $('.sub-nav--item')
            this.accountCard = $('.account-card')
            this.accountCard.hide()
            $('#profile').show()

            this.lockable = $("input, textarea")
            this.pendingMessage = $('.pending-message')
            if(this.pendingMessage.attr('data-status') == 'pending'){
                this.lockable.prop('disabled', true)
            }
            this.switchDraft = $('#switch')
            this.dropArea = $('#drop-area')
            this.autosaveBtn = $('#auto-save-btn')
            this.btn = document.getElementById('submit-profile-btn')
            this.postID = $('#profile-edit-form').data('postid')
            this.moreInfo = $(':checkbox')
            this.locate = document.getElementById('locate')
            this.lat = document.getElementById('lat')
            this.lng = document.getElementById('lng')
            this.same = document.getElementById('same-as-location')
            this.sameContent = $('#same-as-location-content')
            this.saveBtn = $('#save-profile-btn')
            this.events();
        }

    }

    events(){
        imgUpload(this.dropArea)
        this.addToCart.on('click', this.addButton.bind(this))
        this.digitalAddOn.on('click', this.selectAddOn.bind(this))
        this.adnav.on('click', this.showAdvertising.bind(this))
        this.subnav.on('click', this.showCatagory.bind(this))
        this.sameAs.call(this);
        // add switchToDraft so you can switch to draft $("input, textarea").prop('disabled', true)
        // look at getting this editableBtn mode on the go
        this.switchDraft.on('click', this.switchToDraft.bind(this))
        this.saveBtn.on('click', this.updateProfile.bind(this, this.postID, 'draft'))
        this.same.addEventListener("click", this.sameAs.bind(this))
        this.locate.addEventListener("click", this.locating.bind(this))
        this.btn.addEventListener("click", this.updateProfile.bind(this, this.postID, 'pending'))
        document.addEventListener('keyup', this.btnEnable.bind(this))
        //save a second after a key is presses
        document.addEventListener('keyup', this.typingLogic.bind(this))
        this.moreInfo.on('change', this.updateProfile.bind(this, this.postID, 'draft'))
    }

    addButton(e){
        console.log("adding to cart")
        addProductToCart(e.target.dataset.id)
    }

    selectAddOn(e){
        this.digitalAddOn.removeClass('selected-addon')
        e.target.classList.add('selected-addon')
        console.log('product id ' + e.target.dataset.productid)
        pullAddOn.call(this, e.target.dataset.productid)
    }

    //need to find a way to hide all sections show the click on item.
    showCatagory(e){
        this.subnav.removeClass('subnav-selected')
        e.target.classList.add('subnav-selected')
        this.accountCard.hide()
        $('#' + e.target.dataset.id).show('slow')
    }

    showAdvertising(e){
        this.adnav.removeClass('subnav-selected')
        e.target.classList.add('subnav-selected')
        this.adCard.hide()
        $('#' + e.target.dataset.id).show('slow')
    }

    switchToDraft(){
        this.lockable.prop('disabled', false)
        profileDataPull.call(this.moreInfo, this.postID, 'draft')
        this.pendingMessage.hide('slow')
    }

    sameAs(){
        //this does not check if somehting is checked
        //make this more future proof
        // add class to gray out section and not have a none display
        if(this.same.checked == true){
                this.sameContent.find('input').prop('disabled', true) 
        } else {
                this.sameContent.find('input').prop('disabled', false)
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
            $('#autosave-loader').show()
            clearTimeout(this.typingLogic)
            //console.log(this)
            this.typingLogic = setTimeout(() => {
                console.log(this)
                profileDataPull.call(this.moreInfo, this.postID, 'draft')
                $('#autosave-loader').hide('slow')
            }, 1500)
            
        }
    }

    //methods
    updateProfile(postID, status){

        if(requiredCheck()){
            if(status == 'pending'){
                this.lockable.prop('disabled', true)
                this.pendingMessage.show('slow')
            }
            profileDataPull.call(this.moreInfo, postID, status)
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