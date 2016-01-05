<html>
	<head>
		<title>I Love Valorie</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
                <link href='require.css' rel='stylesheet' type='text/css'>
                <link href='bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
                <script type="text/javascript" src="require.js" >
                </script>
                <script type="text/javascript" src="jquery/jquery.min.js" >
                </script>
                <script type="text/javascript" src="bootstrap/js/bootstrap.min.js" >
                </script>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
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
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body onload="playSong();">
		<div class="container">
			<div class="content">
				<div class="title">Welcome My Love</div>
				<div class="quote">{{ Inspiring::quote() }}</div>				<div >
@for ($i = 0; $i < count($music); $i++)
  @if($i==0)
    <audio id="pluginPlayer" src="music/{{ $music[$i]["filename"] }}" >
  @endif
  <source src='music/{{ $music[$i]["filename"] }}' type='audio/mpeg'>
@endfor
  Your browser does not support the audio element.
</audio>
</div>
<div style="padding:10px;margin:10px;">
<fieldset id="nowPlaying">
<legend>
Now Playing
</legend>
</fieldset>
</div>
<div style="padding:10px;margin:10px;">
<button  onclick="playSong()">Play</button> 
<button class="button"  onclick="stopSong();">Stop</button> 
<button class="button" onclick="nextSong()">Next</button> 
<button class="button" onclick="previousSong()">Previous</button>
                        </div>
<div style="padding:10px;margin:10px;">
<div class="col-md-4">
Title
</div>
<div class="col-md-3">
Artist
</div>
<div class="col-md-3">
Album
</div>
<div class="col-md-1">
Year
</div>
<div class="col-md-1">
Track Number
</div>
</div>
@for ($i = 0; $i < count($music); $i++)
  <div class="col-md-12" style="cursor:pointer;" onclick="playFile('music/{{ $music[$i]["filename"] }}');">

<div class="col-md-4" id="title{{ $music[$i]["filename"] }}">
{{ $music[$i]["comments"]["title"][0] }}
</div>
<div class="col-md-3" id="artist{{ $music[$i]["filename"] }}">
{{ $music[$i]["comments"]["artist"][0] }}
</div>
<div class="col-md-3" id="album{{ $music[$i]["filename"] }}">
{{ $music[$i]["comments"]["album"][0] }}
</div>
<div class="col-md-1">
{{{ isset($music[$i]["comments"]["year"]) ? $music[$i]["comments"]["year"][0] : '' }}}
</div>
<div class="col-md-1">
{{{ isset($music[$i]["comments"]["track_number"]) ? $music[$i]["comments"]["track_number"][0] : '' }}}
</div>
</div>
@endfor
			</div>
		</div>
<script type="text/javascript">
 var mymusic = [];
 var timer;
@foreach ($musicArray as $key => $value)
    mymusic['{!! str_replace(array("-", ".", "&", "(", ")"), "", $key) !!}'] = {{$value}}; 
@endforeach

       function playSong() {
            var obj = document.getElementById('pluginPlayer');
            obj.load();
            obj.play();
            console.log(obj.src);
            if ($("#pluginPlayer").attr('src')) {
                var key =  $("#pluginPlayer").attr('src');
            } else {
                var key = obj.src;
            }
	    var parts = key.split("/");
	    console.log(parts);
	    var title = $("#title"+parts[1]).html();
	    var artist = $("#artist"+parts[1]).html();
	    var album = $("#album"+parts[1]).html();
            console.log(key);
            key = key.replace(new RegExp("\\.|-","g"),"");
            key = key.replace(new RegExp("\\/","g"),"");
            key = key.replace(/&/g,"");
            key = key.replace(/amp;/g,"");
            key = key.replace(/\(|\)/g,"");
            console.log(key);
            console.log('key'+mymusic[key]);

            if (mymusic[key]) {
                clearTimeout(timer);
                timer = setTimeout(nextSong, mymusic[key]);
                console.log(timer + " timer");
            }
	    $('#nowPlaying').html("<legend>Now Playing</legend>"+title+"<br/>"+artist+"<br/>"+album);

        }
        function stopSong() {
                        var obj = document.getElementById('pluginPlayer');
            console.log(obj);
            obj.pause();
               clearTimeout(timer);

        }
        function playFile(fileName) {
                                    var obj = document.getElementById('pluginPlayer');
                                   obj.pause();
             $('#pluginPlayer source').each(function() {
                var src = $(this).attr('src');
                 if (src.indexOf(fileName) != -1)  {
                    found = true;
                    obj.src = $(this).attr('src');
                    obj.load();
                    playSong();
                }
            });
        }
        function nextSong() {
                                   var obj = document.getElementById('pluginPlayer');
                                   obj.pause();
            var src = obj.currentSrc;
             var found = false;
            $('#pluginPlayer source').each(function() {
                 if (found) {

                    obj.src = $(this).attr('src');
                    obj.load();
                    playSong();
                    console.log('found' + $(this).attr('src'));
                    found = false;
                }
                if (src.indexOf($(this).attr('src')) != -1)  {
                    found = true;
                }
            });
        }
        function previousSong() {
                                              var obj = document.getElementById('pluginPlayer');
           var src = obj.currentSrc;
             var found = false;
             var count = 0;
            var music = new Array();
            $('#pluginPlayer source').each(function() {
                 if (found) {
                    obj.src = music[music.length-1];
                    obj.load();
                    playSong();
                    console.log('found' + music[music.length-1]);
                    found = false;
                }
                if (src.indexOf($(this).attr('src')) != -1)  {
                    found = true;
                }
                 music.push($(this).attr('src'));
            });
        }
</script>
	</body>
</html>
