import $ from "jquery"
import 'jquery-ui/ui/widgets/datepicker'
import packageDataPull from './Functions/packageDataPull'

class PackageEdit{
    constructor(){
      this.postID = $('#package-edit-form').data('postid')  
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
        this.btn.on('click', this.packageUpdate.bind(this.btn, this.postID))
    }

    packageUpdate(postID){
        packageDataPull.call(this, postID, 'pending')
    }
}

export default PackageEdit