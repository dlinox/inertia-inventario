<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <!--    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/> -->
    <meta meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" (all in angular brackets)/>
    <script>
        function lock(orientacion){
            let de = document.documentElement;
            if(de.requestFullScreen){de.requestFullScreen();}
            else if(de..mozRequestFullscreen){de.mozRequestFullscreen();}
            else if(de..webkitRequestFullscreen){de.webkitRequestFullscreen();}
            else if(de.msRequestFullscreen){de.msRequestFullscreen();}
            
            screen.orientation.lock(orientacion)
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
    <div id="lock">
        "hellow world"
    </div>
    <div id="container">
        @inertia
    </div>
</body>

</html>