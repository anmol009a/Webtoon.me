<!-- Scroll to Top Button -->
<button class="btn btn-dark scroll-to-top" id="scroll-to-top-btn" title="Go to top">
    &uparrow;
</button>

<style>
    /* Add some space to the bottom right corner */
    .scroll-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
    }
</style>

<script>
    // Show or hide the button based on the scroll position
    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        var scrollToTopBtn = document.getElementById("scroll-to-top-btn");

        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    }

    // Scroll to the top when the button is clicked
    document.getElementById("scroll-to-top-btn").addEventListener("click", function () {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
    });
</script>