import $ from 'jquery'
//determin why this isn't working tomorrow!
import 'jquery-ui/ui/widgets/datepicker'

class PackageEdit{
    constructor(){
        $('#package-datepicker').datepicker()
    }  
}

export default PackageEdit