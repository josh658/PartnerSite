import $ from 'jquery'

function requiredCheck(){
    // let required = $('.required')

    let passed = true

  
    $.each($('.required'), function (){
        // console.log(this.val())
        
        if($(this).val() == ""){
            $(this).addClass('required-field')
            passed = false;
        } else {
            $(this).removeClass('required-field')
        }
    })
            
    return passed
}

export default requiredCheck