import $ from 'jquery';

class Search {

    // Constructor
    constructor() {
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");

        this.isOverlayOpen = false;
        this.typingTimer;

        this.events();
    }

    // Events
    events() {
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));

        this.searchField.on("keydown", this.typingLogic.bind(this));
        $(document).on("keydown", this.keyPressDispatcher.bind(this));
    }

    // Methods
    typingLogic() {
        clearTimeout(this.typingTimer);

        this.typingTimer = setTimeout(function() {
            console.log("howdy");
        }, 2000);
    }

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
