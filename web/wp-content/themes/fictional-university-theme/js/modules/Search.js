import $ from 'jquery';

class Search {

    constructor() {
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");

        this.isOverlayOpen = false;

        this.events();
    }

    // Events
    events() {
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));

        $(document).on("keydown", this.keyPressDispatcher.bind(this));
    }

    // Methods
    keyPressDispatcher(event) {
        if (event.keyCode === 83 && !this.isOverlayOpen) {
            this.openOverlay();
        }

        if (event.keyCode === 27 && this.isOverlayOpen) {
            this.closeOverlay();
        }
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        this.isOverlayOpen = true;
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.isOverlayOpen = false;
    }

}

export default Search;
