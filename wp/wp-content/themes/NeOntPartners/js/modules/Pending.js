import $ from 'jquery'

class Pending {
    constructor(){
        this.pendingBox = $('.pending-card--small')
        this.event()
    }

    event(){
        this.pendingBox.on('click',this.enlarge)
    }

    enlarge(){
        this.tmp = $('.pending-card--large')
        this.tmp.removeClass("pending-card--large")
        this.tmp.addClass('pending-card--small')
        $(this).removeClass('pending-card--small')
        $(this).addClass('pending-card--large')
        setTimeout(() => {
            $('html, boday, main').animate({
                //ugly equation to get it to sit nicely under the header... yuck
                scrollTop: ($(this).offset().top - $('#sticky').height() - $('#wpadminbar').height() - 5)
            }, 500)
        }, 250)

    }

}

export default Pending