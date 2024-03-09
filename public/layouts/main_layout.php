<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./public/responsivity/responsivity.css">
    <link rel="stylesheet" href="./public/layouts/main_layout.css">
</head>

<body>
    <div style="display: flex; flex-direction: row;">
        <div class="bar-button">
            <span style="font-size:30px;cursor:pointer" onclick="changeSideNavVisibility();">&#9776;</span>
        </div>
        <div class="top-nav" style="width:100%;">
            <a href="#" id="home" class="active" onclick="navItemClicked(this);"><i class="fa fa-fw fa-home"></i> Home</a>
            <a href="#" id="search"  onclick="loadContent(this);"><span class="fa fa-fw fa-search"></span> Search</a>
            <a href="#" id="contact" onclick="loadContent(this);"><span class="fa fa-fw fa-envelope"></span> Contact</a>
            <a href="#" id="login"  onclick="loadContent(this);"><span class="fa fa-fw fa-user"></span> Login</a>
        </div>
    </div>

    <div class="container">
        <div id="mySidenav" class="side-nav side-nav-visible">
            <a href="#" id="about" class="active" onclick="loadContent(this);"> <span class="fa fa-fw fa-info-circle"></span>About</a>
            <a href="#" id="services" onclick="loadContent(this);"> <span class="fa fa-fw fa-wrench"></span>Services</a>
            <a href="#" id="people" onclick="loadContent(this);"> <span class="fa fa-fw fa-user"></span>People</a>
            <a href="#" id="contact" onclick="loadContent(this);"> <span class="fa fa-fw fa-address-book"></span>Contact</a>
            <a href="#" id="music" onclick="loadContent(this);"> <span class="fa fa-fw fa-music"></span>Music</a>
            <a href="#" id="product" onclick="loadContent(this);"> <span class="fa fa-fw fa-archive"></span>Products</a>
        </div>

        <div class="view-area" id="view-area">
            <object id="viewArea" type="text/html" data="" style="width:100%; height:100%; margin:0; padding:0;"></object>
           
        </div>
    </div>


    <script>
        function changeSideNavVisibility() {
            //debugger;
            if (document.getElementById("mySidenav").classList.contains("side-nav-visible")) {
                document.getElementById("mySidenav").classList.remove("side-nav-visible");
                document.getElementById("mySidenav").style.display = "none";
                document.getElementById("mySidenav").style.visibility = "hidden";
            } else {
                document.getElementById("mySidenav").classList.add("side-nav-visible");
                document.getElementById("mySidenav").style.display = "";
                document.getElementById("mySidenav").style.visibility = "visible";
            }
        }

        function navItemClicked(element) {
            document.querySelectorAll('.top-nav a').forEach((aELement) => {
                aELement.classList.remove("active");
            });
            document.querySelectorAll('.side-nav a').forEach((aELement) => {
                aELement.classList.remove("active");
            });
            element.classList.add("active");
        }

        function loadContent(element) {
            navItemClicked(element );
            var viewAreaElement = document.getElementById("viewArea");
            switch( element.id ) {
                case "music"            : viewAreaElement.setAttribute("data", "./app.php?service=playVideo"); break;
                case "people"           : viewAreaElement.setAttribute("data", "./app.php?service=showPeopleAsTable"); break;
                case "product"          : viewAreaElement.setAttribute("data", "./app.php?service=showProductsAsTable"); break;
                default                 : viewAreaElement.setAttribute("data", ""); break;
            }
            //document.getElementById("viewArea").setAttribute("data", theContent);
        }
    </script>
</body>

</html>
