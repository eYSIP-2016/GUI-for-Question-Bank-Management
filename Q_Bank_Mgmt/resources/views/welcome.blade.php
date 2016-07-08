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
            
            function wrapText(imageElem, context, text, x, y, maxWidth, lineHeight, format, hiddenID) {
                var cars = text.split("\n");
                var ht = cars.length;
                var h = 60+(ht-1)*lineHeight;
                context.canvas.setAttribute("height",h);

                if(format === "question"){
                    context.fillStyle = "#ffffff";
                    context.fillRect(0, 0, 600, 500);

                    y=20;
                    context.font = "17px 'Arial'";
                    context.fillStyle = "#000000";
                 }
                 else{
                    context.fillStyle = "#b3b3b3";
                    context.fillRect(0, 0, 600, 500);

                    y=20;
                    context.font = "17px 'Courier'";
                    context.fillStyle = "#000000";
                 }

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
                    document.getElementById(hiddenID).setAttribute("value",imageElem.src);
                    y += lineHeight;
                }
             }

             function drawText(textAreaId,previewId,textcanvas,format,hiddenID) {
                 var canvas = document.getElementById(textcanvas);
                 var context = canvas.getContext("2d");
                 var imageElem = document.getElementById(previewId);

                 context.clearRect(0, 0, 100, 600);

                 var maxWidth = 600;
                 var lineHeight = 16;
                 var x = 10; // (canvas.width - maxWidth) / 2;
                 var y = 10;


                 var text = document.getElementById(textAreaId).value;                

                 wrapText(imageElem, context, text, x, y, maxWidth, lineHeight, format, hiddenID);
             }

            function makePreview(textAreaId,previewId,hiddenID){
                var latexCode = document.getElementById(textAreaId).value;
                var link="https://latex.codecogs.com/gif.latex?";
                var linkToImage=link.concat("",latexCode.replace("\s+","&nbsp;"));
                document.getElementById(previewId).setAttribute("src",linkToImage);
                document.getElementById(hiddenID).setAttribute("value",linkToImage);
            }

          function makeOptions(){
                var number = document.getElementById("no_questions").value;
                document.getElementById("options_no").setAttribute("value",number);
                // Container <div> where dynamic content will be placed
              if(number>1&&number<7){
                  var container = document.getElementById("container");

                // Clear previous contents of the container
                  while (container.hasChildNodes()) {
                      container.removeChild(container.lastChild);
                  }
                
                for (i=0;i<number;i++){
                    // Append a node with a random text
                    container.appendChild(document.createTextNode(" Member" + (i+1)+"  "));
                    // Create an <input> element, set its type and name attributes
                    var input = document.createElement("input");
                    input.type = "text";
                    input.name = "member"+i;
                    input.required = "required";
                    input.class = "form-control";
                    container.appendChild(input);
                    // Append a line break 
                    container.appendChild(document.createElement("br"));
                }

                container.appendChild(document.createTextNode(" Choose the answer: "));
                
                for (i=0;i<number;i++){
                    // Append a node with a random text
                    container.appendChild(document.createTextNode((i+1) + "."));
                    // Create an <input> element, set its type and name attributes
                    var input = document.createElement("input");
                    input.type = "radio";
                    input.name = "answer";
                    input.value = i;
                    input.required = "required";
                    input.class = "form-control"
                    container.appendChild(input);
                }
            }
            else{
              alert("Choose a number first :)");
            }
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
        {!! Form::open(['url' => '/','files' => true]) !!}

        <div class="form-group">
                    
                    {!! Form::label('Q_desc','Description') !!}
                    
                    {!! Form::textarea('Q_desc','',array('rows'=>'10','cols'=>'700','class'=>'form-control','required'=>'required','maxlength'=>'400','onkeyup'=>"drawText('Q_desc','desc_preview','canvas_id','question','hidden_desc_url_id')")) !!}
                    
                    {!!  Form::hidden('hidden_desc_url','',array('id'=>'hidden_desc_url_id')) !!}

        </div> 
                <br>

                <img id="desc_preview"><br>
                <canvas id="canvas_id" width="800" hidden></canvas>
                
        {!! Form::submit('Submit') !!}

        {!! Form::close() !!}
    </body>
</html>
