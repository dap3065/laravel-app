<html>
	<head>
		<title>I Love Valorie</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

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
				<div class="title">Welcome My Love Valorie</div>
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
			</div>
		</div>
<script type="text/javascript">
 var mymusic = [];
@foreach ($musicArray as $key => $value)
    mymusic['{{!! str_replace(array("-", ".", "&", "(", ")"), "", $key) !!}}'] = {{$value}}; 
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
