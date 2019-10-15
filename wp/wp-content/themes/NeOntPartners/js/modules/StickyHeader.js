class StickyHeader{
    constructor(){
        this.stickyClass = document.getElementsByClassName("customize-support")
        this.stickyId = document.getElementById("sticky")
        this.events();
    }

    events(){
        window.addEventListener("load", this.pageFullyLoaded.bind(this), false)
    }

    pageFullyLoaded(e){
        this.stickyId.className = this.stickyClass[0] ? "admin-bar" : "sticky-header"
    }
}

export default StickyHeader