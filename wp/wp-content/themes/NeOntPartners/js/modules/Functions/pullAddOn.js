import $ from 'jquery'

function pullAddOn(productId){
    // pull information in from custom rest route

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

            this.addOnTitle.html(response.title)
            this.addOnDescription.html(response.description)
            this.addOnButton.attr("data-id", response.addToCartURL)
        },
        error: (response) => {
            console.log("Error")
            console.log(response)
        }
    })
}

export default pullAddOn