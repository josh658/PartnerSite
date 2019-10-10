class Search{
    // 1. describe and create/initiate our object
    constructor(){
        this.openSearch = document.getElementById("main-search")
        this.closeSearch = document.getElementById("close-main-search")
        this.searchOverlay = document.getElementById("search-overlay")
    }

    // 2. events
    events(){
        this.openSearch.addEventListener('click', this.openOverlay)
        this.closeOverlay.addEventListener('click', this.closeOverlay)
    }

    // 3. methods (function, action...)
    openOverlay(){
        this.searchOverlay.classList.add('show-overlay')
    }

    closeOverlay(){
        this.searchOverlay.classList.remove("show-overlay")
    }
}

export default Search;