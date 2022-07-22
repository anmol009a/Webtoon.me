<header>
    <div id="search-div" class="bg-info d-none">
        <form id="search-form" action="search_results.php?" method="get" class="d-inline">
            <input id="search-input" class="py-2 px-4" type="search" value placeholder="Search..." name="s" aria-label="Search" autocomplete="off">
            <button id="search-btn" title="Search" class="btn btn-success" type="submit">Search</button>
        </form>
        <ul id="search-items-container">
            <!-- search items goes here -->
        </ul>

        <script>
            const searchForm = document.getElementById("search-form");
            searchForm.onclick() = searchForm.setAttribute("action", "search_results.php?s=" + document.getElementById(search - input).value);
        </script>

    </div>


    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">WebtoonWorld.xyz</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="all_webtoons.php">All Webtoons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="completed_webtoons.php">Completed</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="auto_add_webtoon.php">Auto Add Webtoon</a></li>
                            <li><a class="dropdown-item" href="auto_update.php">Auto Update</a></li>
                            <li><a class="dropdown-item" href="update_webtoon.php">Update Webtoon</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <button id="search-icon" title="Search" class="float-end mx-1 p-1" onclick="toogleSearchDiv();">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
        </div>
    </nav>
</header>

<script>
    function toogleSearchDiv() {
        document.getElementById("search-div").classList.toggle('d-none');
    }

    // ==================
    // logic for search
    {
        const searchInput = document.getElementById("search-input");
        // const input = document.querySelector('#search');

        const searchItems = document.getElementById("search-items-container")

        searchInput.addEventListener('input', searchWebtoon);


        function searchWebtoon(e) {
            console.log('searching');
            searchUrl = 'search.php?s=' + e.target.value;
            searchWebtoons(searchUrl).then(webtoonsFound => searchItems.innerHTML = webtoonsFound);
            console.log('searching done');
        }

        async function searchWebtoons(searchUrl) {
            const response = await fetch(searchUrl);
            const webtoonsFound = await response.text();
            return webtoonsFound;
        }

        searchInput.addEventListener("blur", () => setTimeout(() => searchItems.innerHTML = "", 100));
        // setTimeout(() => searchItems.innerHTML = "", 1000);
    }
</script>