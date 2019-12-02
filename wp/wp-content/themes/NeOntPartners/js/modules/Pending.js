import $ from 'jquery'

class Pending {
    constructor(){
        this.pendingBox = $('.pending-card--small')
        this.editBtn = $('.edit-btn')
        this.event()
    }

    event(){
        this.pendingBox.on('click',this.enlarge)
        this.editBtn.on('click', this.toggleEdit)
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
        } else {
            $(toggle).find('input, textarea').prop('disabled', false)
            $(toggle).data('state', 'editable')
        }
    }

}

export default Pending