<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <script type="text/javascript">
            
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
        </style>
    </head>
    <body>
        {!! Form::open(['url' => '/']) !!}

                {!! Form::label('Q_exp','Mathematical Expressions') !!}<br>

                {!! Form::hidden('hiddenId','https://latex.codecogs.com/gif.latex?\int&space;\bigcap',array('id' => 'hiddenId')) !!}

                {!! Form::textarea('Q_exp','',array('rows'=>'10','cols'=>'70')) !!}<br>

                {!! Form::button('Make Prevew', array( 'onClick'=>"makePreview('Q_exp','previewId','hiddenId')")) !!}

                <img src="" width="auto" height="auto" id="previewId">

                {!! Form::submit('Submit') !!}

        {!! Form::close() !!}
    </body>
</html>
