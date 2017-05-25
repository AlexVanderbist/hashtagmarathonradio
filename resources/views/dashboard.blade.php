<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

    <title>Hashtag Marathonradio | Marathonradio Statistieken | #marathonradio</title>
</head>
<body>
    <div id="app">
        <section class="hero">
            <div class="hero-body">
                <div class="container">
                    <img src="{{asset("images/logo.png")}}" alt="Marathonradio" id="logo">

                    <h1 class="title">
                        De onofficiële #marathonradio statistieken!
                    </h1>
                    <h2 class="subtitle">
                        Dag <span id="dayCount"></span> van Marathonradio! <small>(speciaal voor Tom ;)</small>
                    </h2>
                    <p>Teller loopt sinds 4 juni 2016 en vernieuwt iedere 5 seconden.<br/>Laatste update om <span id="lastRefresh"></span></p>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container is-fluid">
                <dashboard></dashboard>
            </div>
        </section>

        <footer class="footer">
            <div class="container">
                <div class="content has-text-centered">
                    Het MNM &amp; Marathonradio logo zijn eigendom van MNM.<br>
                    Niet officieel geassocieerd met MNM.<br>
                    Gemaakt door <a target="_blank" href="https://twitter.com/AlexVanderbist">&commat;AlexVanderbist</a>
                </div>
            </div>
        </footer>
    </div>

    <script src="js/app.js"></script>
</body>
</html>