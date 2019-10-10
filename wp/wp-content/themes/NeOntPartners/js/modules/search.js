class Search{
    // 1. describe and create/initiate our object
    constructor(){
        this.openSearch = document.getElementById("main-search")
        this.closeSearch = document.getElementById("close-main-search")
        this.searchOverlay = document.getElementById("search-overlay")
        this.events();
    }

    // 2. events
    events(){
        this.openSearch.addEventListener('click', this.openOverlay.bind(this))
        this.closeSearch.addEventListener('click', this.closeOverlay.bind(this))
    }

    // 3. methods (function, action...)s
    openOverlay(){
        this.searchOverlay.style.display = "block"
    }

    closeOverlay(){
        this.searchOverlay.style.display = "none"
    }
}

export default Search;