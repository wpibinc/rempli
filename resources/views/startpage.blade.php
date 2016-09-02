<!doctype html>

<!--–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  jquery.mb.components                                                                                                                              –
                                                                                                                                                    –
  file: demo.html                                                                                                                                   –
  last modified: 21/06/15 15.53                                                                                                                     –
                                                                                                                                                    –
  Open Lab s.r.l., Florence - Italy                                                                                                                 –
                                                                                                                                                    –
  email: matteo@open-lab.com                                                                                                                        –
  site: http://pupunzi.com                                                                                                                          –
        http://open-lab.com                                                                                                                         –
  blog: http://pupunzi.open-lab.com                                                                                                                 –
  Q&A:  http://jquery.pupunzi.com                                                                                                                   –
                                                                                                                                                    –
  Licences: MIT, GPL                                                                                                                                –
     http://www.opensource.org/licenses/mit-license.php                                                                                             –
     http://www.gnu.org/licenses/gpl.html                                                                                                           –
                                                                                                                                                    –
  Copyright (c) 2001-2015. Matteo Bicocchi (Pupunzi);                                                                                               –
  –––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––-->

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Start Page</title>

    <link href='http://fonts.googleapis.com/css?family=Lekton|Lobster' rel='stylesheet' type='text/css'>
    <style type="text/css">
        @font-face {
            font-family: 'MalgunGothicBold';
            src: url('fonts/MalgunGothicBold.woff') format('woff'),
            url('fonts/MalgunGothicBold.ttf') format('truetype'),
            url('fonts/MalgunGothicBold.svg#MalgunGothicBold') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'Helvetica-Black_cyr-Bold';
            src: url('fonts/Helvetica-Black_cyr-Bold.woff') format('woff'),
            url('fonts/Helvetica-Black_cyr-Bold.ttf') format('truetype'),
            url('fonts/Helvetica-Black_cyr-Bold.svg#Helvetica-Black_cyr-Bold') format('svg');
            font-weight: normal;
            font-style: normal;
        }




        body{
            background: #284352;
            z-index:0;
            margin:0;
            padding:0;
            font:normal 16px/20px Lekton, sans-serif;
            }
      
        #wrapper{
            position:absolute;
            padding:100px 50px;
            width:100%;
            min-height: 100%;
            margin-left: 0;
            top:0;
            background: rgba(0, 0, 0, .4);
            font:normal 16px/20px Lekton, sans-serif;
            box-sizing: border-box;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);

        }

        #controls .next{
            top: 50%;
            margin-top: 10px;
            position: absolute;
            cursor: pointer;
            opacity: .4;
            background: url('img/arrow-right.png') no-repeat center center;
            -webkit-transition: all 0.2s ease-out;
            -moz-transition: all 0.2s ease-out;
            -o-transition: all 0.2s ease-out;
            transition: all 0.2s ease-out;
            transform: translateY(-50%);
            right: 150px;
            width: 31px;
            height: 58px;
            z-index: 100000;
        }
        #controls .prev {
            top: 50%;
            margin-top: 10px;
            position: absolute;
            cursor: pointer;
            opacity: .4;
            background: url('img/arrow-left.png') no-repeat center center;
            -webkit-transition: all 0.2s ease-out;
            -moz-transition: all 0.2s ease-out;
            -o-transition: all 0.2s ease-out;
            transition: all 0.2s ease-out;
            transform: translateY(-50%);
            left: 150px;
            width: 31px;
            height: 58px;
            z-index: 100000;
        }
       
        .big-text{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);

        }
        .big-text ul{
            position: relative;
            width: 300px;
        }
        .big-text li{
            list-style: none;
            color: #fff;
            font-size: 40px;
            padding: 20px 40px;
            border:1px solid #fff;
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
        }
        .start-shop{
            display: table;
            font-size: 30px;
            padding: 20px 30px;
            background-color: #f3b547;
            text-transform: uppercase;
            text-decoration: none;
            color: #fff;
                margin: 30px auto;
            font-family: 'MalgunGothicBold';
        }
        .start-shop:hover{
            background-color: #f5ae31;
            text-transform: uppercase;
            text-decoration: none;
            color: #fff;
        }
        .start-shop:active{
            background-color: #dc9820;
            text-transform: uppercase;
            text-decoration: none;
            color: #fff;
        }
        .heder-top{
            position: absolute;
            top: 0;
            z-index: 999;
            left: 0;
            height: 60px;
            width: 100%;
        }
        .logo{
            float: left;
            margin-left: 20px;
            font-size: 42px;
            font-family: 'Helvetica-Black_cyr-Bold';
            color: #fff;
            margin-top: 9px;
        }
        .leng{
            margin-right: 20px;
            height: 60px;
            float: right;
        }
        .leng img{
            margin: 15px 5px;
            height: 30px;
        }
        .leng a{
            text-decoration: none;
            display: inline-block;

        }
        .leng a.active img{
            margin: 15px 5px;
            padding: 1px;
            height: 27px;
            border: 1px solid #f3b547;
        }
    </style>

    <link href='jquery.mb.bgndGallery-master/css/jquery.mb.bgndgallery.min.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" media="screen" href="res/css/style.css"/>
    

</head>
<body>
<header class="heder-top">
    <div class="logo">
        Rempli
    </div>
    <div class="leng">
    <a href="#" class="rus">
        <img src="img/russ.png" alt="Ru">
    </a>
     <a href="#" class="en active">
        <img src="img/en.png" alt="En">
    </a>
    </div>
</header>
<div id="wrapper">
        <div id="content-slider">
        <div id="slider">
            <div id="mask">
            <ul>
            <li id="first" class="firstanimation">
            BORN INTO CREATIVITY
            </li>

            <li id="second" class="secondanimation">
            FOCUSED ON STRATEGY
            </li>
            
            <li id="third" class="thirdanimation">
            we are Calliope
            </li>
                        
            <li id="fourth" class="fourthanimation">
            BORN INTO CREATIVITY
            </li>
                        
            <li id="fifth" class="fifthanimation">
            we are Calliope
            </div>
            <a href="#" class="start-shop">Shopping now</a>
        </div>
    </div>
    <div id="controls">
        <div class="prev"></div>
        <div class="next"></div>
    </div>



</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.js"></script>
    <script type="text/javascript" src="jquery.mb.bgndGallery-master/jquery.mb.bgndGallery.min.js"></script>


    <script type="text/javascript">

     

        $(function(){
            myGallery = new mbBgndGallery({
                containment:"body",
                timer:100,
                effTimer:1000,
                controls:"#controls",
                grayScale:false,
                shuffle:true,
                autoStart:false,
                preserveWidth:false,
//                filter: {grayscale: 100},
                effect:"zoom",
                images:[
                    "img/slide-1.jpg",
                    "img/slide-2.jpg",
                    "img/slide-3.jpg",
                    "img/slide-4.jpg",
                    "img/slide-5.jpg"
                ]
            
            });

        });
        
    </script>

</body>
</html>


