class SendProfileInfo{
    constructor(){
        this.btn = document.getElementById('Submit-Profile')

        this.events();
    }

    events(){
        this.btn.addEventListener("click", this.sendInfo)
    }

    //methods
    sendInfo(){
        
    }
}
export default SendProfileInfo