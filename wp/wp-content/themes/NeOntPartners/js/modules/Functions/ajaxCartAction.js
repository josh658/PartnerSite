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
            $(".cart-button").html("Cart(" + response.cart +")")
            this.cartAction.attr('data-action', response.action)
            this.cartAction.removeClass()
            switch (response.action){
                case "add":
                    this.cartAction.addClass('cart-action-btn cart-add-btn')
                    break;
                case "remove":
                    this.cartAction.addClass('cart-action-btn cart-remove-btn')
                    break;
                case "ordered":
                    this.cartAction.addClass('cart-action-btn cart-ordered-btn')
                    this.cartAction.attr('disabled', true)
                    break;
                default:
                    console.log("action not specified")
            }
        },
        error: (response) => {
            console.log("Error")
            console.log(response)
        }
    })

}

export default ajaxCartAction