import $ from 'jquery'

function packageDataPull(postID, postStatus){
    var updates = {
        'postID': postID,
        'title': $(this).siblings("#package-name").val(),
        'content': $(this).parents('div, section, form').find("#package-desc").val(),
        'startDate': $(this).parents('div, section, form').find("#start").val(),
        'endDate': $(this).parents('div, section, form').find("#end").val(),
        'status': postStatus
    }

    $.ajax({
        beforeSend:(xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', data.nonce);
        },

        url: data.root_url + '/wp-json/neont/v1/packages',
        type:'POST',
        data: updates,
        success: (response) => {
            console.log("Congrats")
            console.log(updates)
            console.log(response)
        },
        error: (response) => {
            console.log("Error")
            console.log(response)
        }
    })
}
export default packageDataPull