import $ from "jquery"
import 'jquery-ui/ui/widgets/datepicker'
import packageDataPull from './Functions/packageDataPull'
import imageUpload from './Functions/imgUpload'

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

      this.btn = $("#submit-package")
      this.dropArea = $('#drop-area')
        if( window.location.pathname == '/packages-editing/'){
          this.events();  
        }

    }

    events(){
      imageUpload(this.dropArea)
      this.btn.on('click', this.packageUpdate.bind(this.btn, this.postID))
      $('main').on('keyup', this.typingLogic.bind(this))
    }

    typingLogic(e){
      clearTimeout(this.typingLogic)
      this.typingLogic = setTimeout(packageDataPull.bind(e.target, this.postID, 'draft'), 1500)
  }

    packageUpdate(postID){
        packageDataPull.call(this, postID, 'pending')
        window.location.replace(data.root_url + "/profile-edit")
    }
}

export default PackageEdit