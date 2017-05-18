<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marathonradio Countdown</title>
    <link rel="stylesheet" href="css/countdown.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
</head>

<body>
<div class="container">
    <div class="row middle-xs h-100">
        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
            <div class="box">
                <div class="card">
                    <img class="logo" src="images/logo.png" alt="Marathonradio">
                    <h1>Marathonradio komt terug op 5 juni!</h1>
                    <h2>en ook HashtagMarathonradio.be is er weer bij.</h2>

                    <ul id="countdown">
                        <li id="days">
                            <div class="number">00</div>
                            <div class="label">Dagen</div>
                        </li>
                        <li id="hours">
                            <div class="number">00</div>
                            <div class="label">Uren</div>
                        </li>
                        <li id="minutes">
                            <div class="number">00</div>
                            <div class="label">Minuten</div>
                        </li>
                        <li id="seconds">
                            <div class="number">00</div>
                            <div class="label">Seconden</div>
                        </li>
                    </ul>

                </div>

                <footer>
                    Het MNM &amp; Marathonradio logo zijn eigendom van MNM.<br>
                    Niet officieel geassocieerd met MNM.<br>
                    Gemaakt door <a target="_blank" href="https://twitter.com/AlexVanderbist">@AlexVanderbist</a><br>
                </footer>
            </div>
        </div>
    </div>
</div>

<script src="js/countdown.js"></script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-78767994-1', 'auto');
    ga('send', 'pageview');
</script>
</body>

</html>