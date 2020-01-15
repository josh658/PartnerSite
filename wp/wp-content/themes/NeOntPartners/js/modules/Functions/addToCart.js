import $ from 'jquery'

function addToCart(productURL){
    // when button pushed, pull url from add_to_cart_url().
    
    $.ajax({
        beforeSend:(xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', data.nonce);
        },
        
        url: data.root_url + productURL,
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

export default addToCart