import $ from 'jquery'
import profileDataPull from './Functions/profileDataPull'
import packageDataPull from './Functions/packageDataPull'

class Pending {
    constructor(){
        this.pendingBox = $('.pending-card--small')
        this.editBtn = $('.edit-btn')
        this.publishBtn = $('.publish-btn')
        this.closeBtn = $('.pending-card-close')
        this.closeBtn.hide()
        this.event()
    }

    event(){
        this.pendingBox.on('click',this.enlarge)
        this.editBtn.on('click', this.toggleEdit)
        this.publishBtn.on('click', this.publish)
        this.closeBtn.on('click', this.shrink.bind(this))
    }

    shrink(e){
        e.stopPropagation();
        this.currentCard = $(e.target).parents('.pending-card--large')
        this.currentCard.addClass('pending-card--small').removeClass("pending-card--large")
        this.currentCard.find('.isShown').addClass('isHidden').removeClass('isShown')
        this.currentCard.find('.pending-card-close').hide()
    }

    enlarge(){
        if($(this).hasClass('pending-card--small')){
            this.tmp = $('.pending-card--large')
            this.tmp.addClass('pending-card--small')
            this.tmp.removeClass("pending-card--large")
            this.tmp.children('.isShown').addClass('isHidden').removeClass('isShown')
            this.tmp.find('.pending-card-close').hide()
            
            $(this).addClass('pending-card--large').removeClass('pending-card--small')
            // $(this).removeClass('pending-card--small')
            $(this).children('.isHidden').addClass('isShown').removeClass('isHidden')
            $(this).find('input, textarea').prop('disabled', true)
            $(this).find('.pending-card-close').show()
            
            setTimeout(() => {
                $('html, boday, main').animate({
                    //ugly equation to get it to sit nicely under the header... yuck
                    scrollTop: ($(this).offset().top - $('#sticky').height() - $('#wpadminbar').height() - 5)
                }, 500)
            }, 250)
        }
    }

    toggleEdit(){
        let toggle = $(this).parent('div')
        if($(toggle).data('state') == 'editable'){
            $(toggle).find('input, textarea').prop('disabled', true)
            $(toggle).data('state', 'cancel')
            $(this).html('Edit')
            $(this).siblings('.edit-btn').html('Edit')
            if($(this).parent().data('post-type') == 'partners'){
                profileDataPull.call(this, $(this).parents('.pending-card--large').attr('id'), 'pending')
            } else if($(this).parent().data('post-type') == 'packages'){
                packageDataPull.call(this, $(this).parents('.pending-card--large').attr('id'), 'pending')
            }
        } else {
            $(toggle).find('input, textarea').prop('disabled', false)
            $(toggle).data('state', 'editable')
            $(this).html('Save')
            $(this).siblings('.edit-btn').html('Save')
        }
    }

    publish(){
        if ($(this).parent().data('post-type') == 'partners'){
            //use ajax to publish partners post
            profileDataPull.call(this, $(this).parents('.pending-card--large').attr('id'), 'publish')
            $(this).parents('.pending-card--large').hide()
        } else if ($(this).parent().data('post-type') == 'packages'){
            //use ajax to publish packages post
            packageDataPull.call(this, $(this).parents('.pending-card--large').attr('id'), 'publish')
            $(this).parents('.pending-card--large').hide()
        }
    }
}

export default Pending