import $ from 'jquery'

//make sure it checks before starting

class WordCap{
    //constructor
    constructor(){
        this.wordCount = $('[data-char-cap]')
        this.event()
    }
    //event
    event(){
        this.wordCount.on('keyup', this.cap)
    }

    //methods
    cap(){
        let max = $(this).data('char-cap')
        let current = $(this).val().length
        if(current >= max){
            $(this).addClass('char-cap')
        } else {
            $(this).removeClass('char-cap')
        }
    }
}

export default WordCap