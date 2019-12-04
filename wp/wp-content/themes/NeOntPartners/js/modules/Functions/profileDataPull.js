import $ from 'jquery'

function profileDataPull(postID, post_status){
    if(postID != ""){
        //EDIT THIS TO ADD MORE ITEMS
        
        //alert($(this).parents('div,section,form').find("[name=accomodations]:checked").val())
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
                'secondary_contact_firstname': $(this).parents('div,section,form').find("#s-first-name").val(),
                'secondary_contact_lastname': $(this).parents('div,section,form').find("#s-last-name").val(),
                'secondary_contact_email': $(this).parents('div,section,form').find("#s-email").val() ,
                'website_url' : $(this).parents('div,section,form').find("#website").val(),
                'business_email': $(this).parents('div,section,form').find("#business-email").val(),
                'business_street_address': $(this).parents('div,section,form').find("#business-addr").val(),
                'business_city': $(this).parents('div,section,form').find("#b-city").val(),
                'business_postal_code': $(this).parents('div,section,form').find("#b-postal-code").val(),
                'latitude': $(this).parents('div,section,form').find("#lat").val(),
                'longitude': $(this).parents('div,section,form').find("#lng").val(),
                'business_phone_number': $(this).parents('div,section,form').find("#b-phonenumber").val(),
                'toll_free_number': $(this).parents('div,section,form').find("#toll-free").val(),
                'head_office_street_address': $(this).parents('div,section,form').find("#head-addr").val(),
                'head_office_city': $(this).parents('div,section,form').find("#head-city").val(),
                'head_office_provincestate': $(this).parents('div,section,form').find("#head-province").val(),
                'head_office_postal_code': $(this).parents('div,section,form').find("#head-postal").val(),
                'head_office_phone_number': $(this).parents('div,section,form').find("#head-phone").val()
            },
            'postID': postID,
            'title': $(this).parents('div,section,form').find("#comp-name").val(),
            'content': $(this).parents('div,section,form').find("#desc").val(),
            'status': post_status,
            //contact 1 information is saved directly to user
            'contactFirstName': $(this).parents('div,section,form').find("#first-name").val(),
            'contactLastName': $(this).parents('div,section,form').find("#last-name").val(),
            'contactEmail': $(this).parents('div,section,form').find("#email").val(),
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

