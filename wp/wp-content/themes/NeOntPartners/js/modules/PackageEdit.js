import $ from 'jquery'
import datepicker from 'js-datepicker'

class PackageEdit{
    constructor(){
        const start = datepicker('.start', { id: 'package-datepicker'})
        const end = datepicker('.end', { id: 'package-datepicker'})
    }  
}

export default PackageEdit