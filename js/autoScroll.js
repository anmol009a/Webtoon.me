    // function autoScroll() {
    //     console.log("Welcome to WebtoonWorld.xyz");
    //     console.log(scrollY);
    //     console.log(scrollX);
    //     let y = scrollY;
    //     while (y < 6000) {
    //         y++;
    //         scroll(0, y);
    //     }
    // }

    // function autoScroll2() {
    //     let y = scrollY;
    //     y++;
    //     scroll(0, y);
    //     console.log('Autoscroll');

    // var intervalID = setInterval(y++;
    // scroll(0, y), [delay]);
    // }
    // ================================================================
    // variable to store our intervalID
    let nIntervalId;

    function startAutoScroll() {
        // check if already an interval has been set up
        if (!nIntervalId) {
            console.log('inside');
            nIntervalId = setInterval(autoScroll, 70);
        }
    }

    function autoScroll() {
        // let y = scrollY;
        // y++;
        // scroll(0, y);
        scroll(0, scrollY + 2);
        console.log(scrollY);
    }

    function stopAutoScroll() {
        clearInterval(nIntervalId);
        console.log(nIntervalId);
        // release our intervalID from the variable
        nIntervalId = null;
        console.log(nIntervalId);
    };

    document.getElementById("auto-scroll-btn").addEventListener("click", startAutoScroll);
    document.getElementById("auto-scroll-btn").addEventListener("blur", stopAutoScroll);