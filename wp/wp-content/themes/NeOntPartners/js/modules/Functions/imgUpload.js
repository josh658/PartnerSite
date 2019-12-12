import $ from 'jquery'

function imgUpload(dropArea){
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
        let files = e.originalEvent.dataTransfer.files
        handleFiles(files)
    }

    function handleFiles(files){
        ([...files]).forEach(file => {            
            previewFile(file)
            let formData = new FormData()
            formData.append('file', file)
            formData.append('fileElem_nonce', $('#fileElem-nonce').val())
            formData.append('parent_id', $('#parent_id').val())

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