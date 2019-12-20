import $ from 'jquery'

function imgUpload(dropArea){

    let imgDeleteBtn = dropArea.find('#delete-img-btn')
    let fileUploadBtn = dropArea.find('#fileElem')
    
    fileUploadBtn.on('change', handleSelect)


    imgDeleteBtn.on('click', imgDelete);

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.on(eventName, preventDefault)
    });
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.on(eventName, highlight)
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.on(eventName, unhighlight)
    });

    dropArea.on('drop', handleDrop)

    function imgDelete(e){
        e.preventDefault()
        e.stopPropagation()

        //empty input file list to help with reloading of other items
        console.log(fileUploadBtn.get(0).files.length)
        dropArea.find('form').get(0).reset()
        console.log(fileUploadBtn.get(0).files.length)
        
        
        
        // UPDATE: must use attr instead of data when retreiving dynamic data. 
        // don't every use data it is a pain in the ass!
        let update = {
            'postID': dropArea.find('img').attr('data-id')
        }        
        
        $.ajax({
            beforeSend:(xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', data.nonce);
            },
            
            url: data.root_url + "/wp-json/neont/v1/imgUpload",
            type:'DELETE',
            data: update,
            success: (response) => {
                dropArea.find('#drop-area-content').show()
                dropArea.find('#delete-img-btn').hide()
                dropArea.find('img').hide()
                console.log("Congrats")
                console.log(response)
            },
            error: (response) => {
                console.log("Error")
                console.log(response)
            }
        })
    }
    
    function preventDefault(e){
        e.preventDefault()
        e.stopPropagation()
    }
    
    function highlight(){
        dropArea.addClass('highlight')
    }
    
    function unhighlight(){
        dropArea.removeClass('highlight')
    }
    
    function handleDrop(e){
        if( dropArea.data('img') < 1 ){
            let files = e.originalEvent.dataTransfer.files
            handleFiles(files)
        } else {
            console.log('prompt them to see if they want to delete the old version')
        }
    }
    
    function handleFiles(files){
        ([...files]).forEach(file => {            
            if(file.type == 'image/jpeg' || file.type == 'image/png' ){
            previewFile(file)
            console.log(file.type)
            let formData = new FormData()
            formData.append('file', file)
            formData.append('fileElem_nonce', $('#fileElem-nonce').val())
            formData.append('parent_id', $('#parent_id').val())
            
            dropArea.find('#drop-area-content').hide()
            // setup a spinning loading wheele instead of update
            dropArea.find('#loading-icon').show()
            

                $.ajax({
                    beforeSend:(xhr) => {
                        xhr.setRequestHeader('X-WP-Nonce', data.nonce);
                    },
                    
                    url: data.root_url + "/wp-json/neont/v1/imgUpload",
                    type:'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: (response) => {
                        dropArea.find('#loading-icon').hide()
                        dropArea.find('#delete-img-btn').show()
                        dropArea.find('#delete-img-btn')
                        dropArea.find('img').attr('data-id', response.ID)
                        
                        console.log("Congrats")
                        console.log(response)
                    },
                    error: (response) => {
                        console.log("Error")
                        console.log(response)
                    }
                })
            } else {
                alert('file type not allowed')
            }
        });
    }

    function previewFile(file){
        let reader = new FileReader()
        reader.readAsDataURL(file)
        reader.onloadend = () => {
            let img = dropArea.find('img')
            img.attr('src', reader.result)
            img.attr('style', 'display: inline-block')
        }
    }

    function handleSelect(){
        if (fileUploadBtn.get(0).files.length > 0){
            handleFiles(fileUploadBtn.get(0).files)
        }
    }

}

export default imgUpload