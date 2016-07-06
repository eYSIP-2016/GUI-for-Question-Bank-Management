<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script>
          $(function () {
            $('#myTab a:last').tab('show')
          })
        </script>
        <script type="text/javascript">
            
            //Event Listeners for javascript
            
            /*function makeTextPreview (){

                var textObj = document.getElementById('Q_exp');
                var tCtx = document.getElementById('textcanvas').getContext('2d');
                var imageElem = document.getElementById('previewId');
                var len = tCtx.measureText(textObj.value).width;
                if (len<200) {
                    tCtx.canvas.width = len;
                    tCtx.fillText(textObj.value, 0, 10);
                }
                else{
                    tCtx.canvas.width = 200;
                    var y_line = Math.ceil(len/200);
                    tCtx.fillText(textObj.value, 0, y_line*10);
                }
                imageElem.src = tCtx.canvas.toDataURL();
                console.log(imageElem.src);
            }*/

            // http: //www.html5canvastutorials.com/tutorials/html5-canvas-wrap-text-tutorial/
            function wrapText(imageElem, context, text, x, y, maxWidth, lineHeight) {
                var cars = text.split("\n");

                for (var ii = 0; ii < cars.length; ii++) {

                    var line = "";
                    var words = cars[ii].split(" ");

                    for (var n = 0; n < words.length; n++) {
                        var testLine = line + words[n] + " ";
                        var metrics = context.measureText(testLine);
                        var testWidth = metrics.width;

                        if (testWidth > maxWidth) {
                            context.fillText(line, x, y);
                            line = words[n] + " ";
                            y += lineHeight;
                        }
                        else {
                            line = testLine;
                        }
                    }

                    context.fillText(line, x, y);
                    imageElem.src = context.canvas.toDataURL();
                    y += lineHeight;
                }
             }

             function drawText() {
                 var canvas = document.getElementById("textcanvas");
                 var context = canvas.getContext("2d");
                 var imageElem = document.getElementById('previewId');

                 context.clearRect(0, 0, 500, 600);

                 var maxWidth = 400;
                 var lineHeight = 16;
                 var x = 10; // (canvas.width - maxWidth) / 2;
                 var y = 10;


                 var text = document.getElementById("Q_exp").value;                

                 context.fillStyle = "#ffffff";
                 context.fillRect(0, 0, 600, 500);

                 context.font = "14px 'Arial'";
                 context.fillStyle = "#000000";

                 wrapText(imageElem, context, text, x, y, maxWidth, lineHeight);
             }

            function makePreview(textAreaId,previewId,hiddenID){
                var latexCode = document.getElementById(textAreaId).value;
                var link="https://latex.codecogs.com/gif.latex?";
                var linkToImage=link.concat("",latexCode.replace("\s+","&nbsp;"));
                document.getElementById(previewId).setAttribute("src",linkToImage);
                document.getElementById(hiddenID).setAttribute("value",linkToImage);
            }


        </script>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }

            canvas{
                border: 1px black solid;
            }
            #textCanvas{
                display: none;
            }


        </style>
    </head>
    <body>
        {!! Form::open(['url' => '/']) !!}

                

                {!! Form::label('Q_exp','Mathematical Expressions') !!}<br>

                {!! Form::textarea('Q_exp','',array('rows'=>'10','cols'=>'70','onkeyup'=>'drawText()')) !!}<br>
                <canvas id="textcanvas" width="600"></canvas><br>
                <img id="previewId">
                {!! Form::button('Make Prevew', array( 'onClick'=>"makePreview('Q_exp','previewId','hiddenId')")) !!}
                
                {!! Form::submit('Submit') !!}

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="homeh">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile">Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages" role="tab" aria-controls="messages">Messages</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#settings" role="tab" aria-controls="settings">Settings</a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div class="tab-pane active" id="homeh" role="tabpanel">hello</div>
                  <div class="tab-pane" id="profile" role="tabpanel">word</div>
                  <div class="tab-pane" id="messages" role="tabpanel">..kcnak ja.</div>
                  <div class="tab-pane" id="settings" role="tabpanel">.djbjh..</div>
                </div>

        {!! Form::close() !!}
    </body>
</html>
