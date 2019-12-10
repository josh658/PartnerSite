


function preventDefault(e){
    e.preventDefault()
    e.stopPropagation()
}

function highlight(){
    this.dropArea.addClass('highlight')
}

function unhighlight(){
    this.dropArea.removeClass('highlight')
}

function handleDrop(e){
    let dt = e.dataTransfer
    let files = dt.files

    this.handleFiles(files)
}

function handleFiles(files){
    ([...files]).forEach(this.uploadFile)
}

function uploadFile(file){
    
}