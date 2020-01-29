import $ from 'jquery'

function ajaxCartAction(action, itemID){
    // when button pushed, pull url from add_to_cart_url().
    
    let update = {
        'action': action,
        'itemID': itemID
    }

    
    $.ajax({
        beforeSend:(xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', data.nonce);
        },
        
        url: data.root_url + "/wp-json/neont/v1/ajaxCartAction",
        data: update,
        type:'POST',
        success: (response) => {

            console.log("Congrats")
            console.log(response)
        },
        error: (response) => {
            console.log("Error")
            console.log(response)
        }
    })

}

export default ajaxCartAction