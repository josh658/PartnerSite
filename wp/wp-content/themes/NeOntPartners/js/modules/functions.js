import $ from 'jquery'

function profileDataPull(postID, post_status){
    if(postID != ""){
        //EDIT THIS TO ADD MORE ITEMS
        
        var accom = []
        $(this).parents('div,section,form').find("[name=accomodations]:checked").each( function(){
            accom.push($(this).val())
        })
        

        let parks = []
        $(this).parents('div,section,form').find("[name=camping]:checked").each( function(){
            parks.push($(this).val())
        })
            
            
        let attract = []
        $(this).parents('div,section,form').find("[name=attractions]:checked").each( function(){
            attract.push($(this).val())
        })
        

        let updates = {
            //acf will be an array made to loop through
            'acfCheckbox': {
                'accomodations': accom,
                'parks': parks,
                'attractions': attract,
                
            },
            'acfString': {
                'secondary_contact_firstname': $("#s-first-name").val(),
                'secondary_contact_lastname': $("#s-last-name").val(),
                'secondary_contact_email': $("#s-email").val() ,
                'website_url' : $("#website").val(),
                'business_email': $("#business-email").val(),
                'business_street_address': $("#business-addr").val(),
                'business_city': $("#b-city").val(),
                'business_postal_code': $("#b-postal-code").val(),
                'latitude': $("#lat").val(),
                'longitude': $("#lng").val(),
                'business_phone_number': $("#b-phonenumber").val(),
                'toll_free_number': $("#toll-free").val(),
                'head_office_street_address': $("#head-addr").val(),
                'head_office_city': $("#head-city").val(),
                'head_office_provincestate': $("#head-province").val(),
                'head_office_postal_code': $("#head-postal").val(),
                'head_office_phone_number': $("#head-phone").val()
            },
            'postID': postID,
            'title': $("#comp-name").val(),
            'content': $("#desc").val(),
            'status': post_status,
            //contact 1 information is saved directly to user
            'contactFirstName': $("#first-name").val(),
            'contactLastName': $("#last-name").val(),
            'contactEmail': $("#email").val(),
        }
        $.ajax({
            beforeSend:(xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', data.nonce);
            },

            url: data.root_url + '/wp-json/neont/v1/profile',
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
    }else{
        console.log("post ID does not exist")
    }  
}

export default profileDataPull