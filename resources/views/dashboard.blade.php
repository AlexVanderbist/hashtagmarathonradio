<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">

    <title>Hashtag Marathonradio | Marathonradio Statistieken | #marathonradio</title>
</head>
<body>
    <div id="app">
        <section class="hero">
            <div class="hero-body p-b-0">
                <div class="container">
                    <div class="columns">
                        <div class="column is-narrow-tablet is-narrow-desktop has-text-centered">
                            <img src="{{asset("images/logo.png")}}" alt="Marathonradio" id="logo">
                        </div>
                        <div class="column">
                            <h1 class="title">
                                De onofficiële #marathonradio statistieken!
                            </h1>
                            <h2 class="subtitle">
                                <day-count></day-count>
                            </h2>
                            <p>
                                Teller loopt sinds 3 juni 2018 en vernieuwt iedere 5 seconden.<br/>
                                <last-update></last-update>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container is-fluid">
                <dashboard :initial-statistics="{{ json_encode($statistics) }}"></dashboard>
            </div>
        </section>

        <footer class="footer">
            <div class="container">
                <div class="content is-small has-text-centered">
                    <p>
                        Het MNM &amp; Marathonradio logo zijn eigendom van MNM.<br>
                        Gemaakt door <a target="_blank" href="https://twitter.com/AlexVanderbist">&commat;AlexVanderbist</a>.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script src="js/app.js"></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-78767994-1', 'auto');
        ga('send', 'pageview');

        setInterval(function() {
            ga('send', 'event', 'HeartBeat', '4min');
        }, 4*1000*60);
    </script>
</body>
</html>
