import $ from 'jquery'
import profileDataPull from './functions'

class Pending {
    constructor(){
        this.pendingBox = $('.pending-card--small')
        this.editBtn = $('.edit-btn')
        this.publishBtn = $('.publish-btn')
        this.event()
    }

    event(){
        this.pendingBox.on('click',this.enlarge)
        this.editBtn.on('click', this.toggleEdit)
        this.publishBtn.on('click', this.publish)
    }

    enlarge(){
        if($(this).hasClass('pending-card--small')){
            this.tmp = $('.pending-card--large')
            this.tmp.removeClass("pending-card--large")
            this.tmp.children('.isShown').removeClass('isShown').addClass('isHidden')
            this.tmp.addClass('pending-card--small')
            $(this).removeClass('pending-card--small')
            $(this).addClass('pending-card--large')
            $(this).children('.isHidden').removeClass('isHidden').addClass('isShown')
            $(this).find('input, textarea').prop('disabled', true)
            // $(this).find('textarea').prop('disabled', true) 
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
        } else {
            $(toggle).find('input, textarea').prop('disabled', false)
            $(toggle).data('state', 'editable')
            $(this).html('Cancel')
            $(this).siblings('.edit-btn').html('Cancel')
        }
    }

    publish(){
        if ($(this).parent().data('post-type') == 'partners'){
            //use ajax to publish partners post
            profileDataPull($(this).parents('.pending-card--large').attr('id'), 'publish')
            $(this).parents('.pending-card--large').hide()
        } else if ($(this).parent().data('post-type') == 'packages'){
            //use ajax to publish packages post

        }
    }
}

export default Pending