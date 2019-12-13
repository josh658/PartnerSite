import $ from 'jquery'

function imgUpload(dropArea){

    let imgDeleteBtn = dropArea.find('#delete-img-btn')
    let fileUploadBtn = dropArea.find('#file-upload-button')

    imgDeleteBtn.on('click', imgDelete);
    fileUploadBtn.on('click', handleDrop);

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

        let update = {
            'postID': dropArea.find('img').data('id')
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
                dropArea.find('img').remove()
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
        // console.log(e.originalEvent.dataTransfer.files)
        if( dropArea.data('img') < 1 ){
            console.log(e.originalEvent.dataTransfer.files)
            let files = e.originalEvent.dataTransfer.files
            handleFiles(files)
        } else {
            console.log('prompt them to see if they want to delete the old version')
        }
    }

    function handleFiles(files){
        ([...files]).forEach(file => {            
            previewFile(file)
            let formData = new FormData()
            formData.append('file', file)
            formData.append('fileElem_nonce', $('#fileElem-nonce').val())
            formData.append('parent_id', $('#parent_id').val())

            dropArea.find('#drop-area-content').hide()
            // setup a spinning loading wheele instead of update
            dropArea.find('#loading-icon').show()

            for ( var pair of formData.values()){
                console.log(pair)
            }
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
                    console.log("Congrats")
                    console.log(response)
                },
                error: (response) => {
                    console.log("Error")
                    console.log(response)
                }
            })
        });
    }

    function previewFile(file){
        let reader = new FileReader()
        reader.readAsDataURL(file)
        reader.onloadend = () => {
            let img = document.createElement('img')
            img.src = reader.result
            document.getElementById('gallery').appendChild(img)
        }
    }

}

export default imgUpload