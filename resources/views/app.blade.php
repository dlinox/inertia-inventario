<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <script>
        function lock (orientation) {
        // (A1) GO INTO FULL SCREEN FIRST
        let de = document.documentElement;
        if (de.requestFullscreen) { de.requestFullscreen(); }
        else if (de.mozRequestFullScreen) { de.mozRequestFullScreen(); }
        else if (de.webkitRequestFullscreen) { de.webkitRequestFullscreen(); }
        else if (de.msRequestFullscreen) { de.msRequestFullscreen(); }

        // (A2) THEN LOCK ORIENTATION
        screen.orientation.lock(orientation);
        }

        // (B) UNLOCK SCREEN ORIENTATION
        function unlock () {
        // (B1) UNLOCK FIRST
        screen.orientation.unlock();

        // (B2) THEN EXIT FULL SCREEN
        if (document.exitFullscreen) { document.exitFullscreen(); }
        else if (document.webkitExitFullscreen) { document.webkitExitFullscreen(); }
        else if (document.mozCancelFullScreen) { document.mozCancelFullScreen(); }
        else if (document.msExitFullscreen) { document.msExitFullscreen(); }
        }

        lock('portrait');
    </script>
    <style>
        html {
            overflow-y: auto !important;
            background: #EFEFEF;
        }

        html::-webkit-scrollbar {
            -webkit-appearance: none;
        }

        html::-webkit-scrollbar:vertical {
            width: 10px;
        }

        html::-webkit-scrollbar-button:increment,
        html::-webkit-scrollbar-button {
            display: none;
        }

        html::-webkit-scrollbar:horizontal {
            height: 10px;
        }

        html::-webkit-scrollbar-thumb {
            background-color: #a9a9a9;
            border-radius: 20px;
            border: 2px solid #f1f2f3;
        }

        html::-webkit-scrollbar-track {
            border-radius: 10px;
        }
    </style>
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @laravelPWA
</head>

<body>    
    <h1>LOCK LANDSCAPE</h1>
    <input type="button" value="Landscape" onclick="lock('landscape')"/>
    <input type="button" value="Landscape Primary" onclick="lock('landscape-primary')"/>
    <input type="button" value="Landscape Secondary" onclick="lock('landscape-secondary')"/>
    
    <h1>UNLOCK</h1>
    <input type="button" value="Unlock" onclick="unlock()"/>
    <h1>LOCK PORTRAIT</h1>
    <input type="button" value="Portrait" onclick="lock('portrait')"/>
    <input type="button" value="Portrait Primary" onclick="lock('portrait-primary')"/>
    <input type="button" value="Portrait Secondary" onclick="lock('portrait-secondary')"/>
    @inertia
</body>

</html>