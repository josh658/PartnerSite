import $ from 'jquery'

function pullAddOn(productId){
    // pull information in from custom rest route

    this.addonLoader.show()
    this.addonDetail.hide()

    var  update = {
        'productID': productId
    }

    $.ajax({
        beforeSend:(xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', data.nonce);
        },
        
        url: data.root_url + "/wp-json/neont/v1/addOnInfo",
        type:'POST',
        data: update,
        success: (response) => {

            console.log("Congrats")
            console.log(response)
            this.addonLoader.hide()
            this.addOnTitle.html(response.title)
            this.addOnDescription.html(response.description)
            this.cartAction.attr("data-action", response.action)
            this.cartAction.attr("data-id", productId)
            this.addOnPrice.html("$" + response.price)
            this.addonDetail.show()
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

export default pullAddOn