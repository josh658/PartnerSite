import $ from "jquery"
import 'jquery-ui/ui/widgets/datepicker'

class PackageEdit{
    constructor(){
        /**
         * the below code will allow for a date picker range
         */
        var dateFormat = "mm/dd/yy",
        from = $( "#start" )
          .datepicker({
            dateFormat: 'dd-M-yy',
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1
          })
          .on( "change", function() {
            to.datepicker( "option", "minDate", getDate( this ) );
          }),
        to = $( "#end" ).datepicker({
          dateFormat: 'dd-M-yy',
          defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          from.datepicker( "option", "maxDate", getDate( this ) );
        });
   
      function getDate( element ) {
        var date;
        try {
          date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
          date = null;
        }
   
        return date;
      }
      /**
       * END of date picker range
       */

      //making the package form editable
      this.btn = $("#submit-package")
      if(this.btn){
          this.event()
      }

    }

    event(){
        this.btn.on('click', this.packageUpdate.bind(this))
    }

    packageUpdate(){
        var updates = {
            'title': $("#package-name").val(),
            'content': $("#package-desc").val(),
            'startDate': $("#start").val(),
            'endDate': $("#end").val(),
            'status': 'pending'
        }

        $.ajax({
            beforeSend:(xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', data.nonce);
            },

            url: 'http://localhost:3000/wp-json/wp/v2/packages/' + document.getElementById('profile-edit-form').dataset.postid,
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
}

export default PackageEdit