<?php
include_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore</title>
    <!-- <link rel="icon" type="image/png" href="images/roalerLogo.png"> -->
    <link rel="stylesheet" href="roaler.css">
    <link rel="stylesheet" href="roaler2.css">
</head>
<body style="margin-left: 250px; overflow:hidden; background-color:bisque; display:flex; flex-direction:row; background-color:gray">

<button type="button" class="add">
  <span class="button__text">Add Item</span>
  <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
</button>

<div id="addConfirm">

<div class="mydict">
	<div>
		<label>
			<input type="radio" name="radio" checked="" value="movie">
			<span>movie</span>
		</label>
		<label>
			<input type="radio" name="radio" value="song">
			<span>song</span>
		</label>
		<label>
			<input type="radio" name="radio" value="article">
			<span>article</span>
		</label>	
	</div>   
</div>

<button id="contribute">Contribute!</button>

</div>

<div id="personalised">

<div class="weathercard">
  <div class="container">
    <div class="cloud front">
      <span class="left-front"></span>
      <span class="right-front"></span>
    </div>
    <span class="sun sunshine"></span>
    <span class="sun"></span>
    <div class="cloud back">
      <span class="left-back"></span>
      <span class="right-back"></span>
    </div>
  </div>

  <div class="card-header">
    <span class="loc">Loading</span>
    <span id="humidity">Loading</span>
    <span id="wind">Loading</span>
  </div>

  <span class="temp">..°</span>

  <div class="temp-scale">
    <span>Celcius</span>
  </div>
</div>


  <div style="padding: 20px; padding-bottom:0px;">
  <input type="text" name="prompt" id="prompt">
  <button id="GoogleSearch">Search</button>

  </div>

  <div id="promptResponse">Write a prompt to Generate</div>

  <div id="gamebox">
  Loading Games...
  
  </div>

</div>


<div id="news">

<h1>Loading...</h1>



</div>
<div id="media"></div>
</body>
</html>

<script type="importmap">
      {
        "imports": {
          "@google/generative-ai": "https://esm.run/@google/generative-ai"
        }
      }
    </script>
  <script type="module">
      import { GoogleGenerativeAI } from "@google/generative-ai";

      // Fetch your API_KEY
      const API_KEY = "AIzaSyDE9P2l92a_9v9FF4NzfiGbJnvBM8Hadgc";

      // Access your API key (see "Set up your API key" above)
      const genAI = new GoogleGenerativeAI(API_KEY);

      // ...

      // The Gemini 1.5 models are versatile and work with most use cases
      const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash"});

      console.log("Gemini accessed")

      document.getElementById('GoogleSearch').addEventListener('click', function() {

        document.getElementById('promptResponse').textContent = 'generating...'
        prompt = document.getElementById('prompt').value
        run(prompt)
      })




      async function run(prompt) {
  // The Gemini 1.5 models are versatile and work with both text-only and multimodal prompts

      // const prompt = "Write a story about a magic backpack."

      const result = await model.generateContent(prompt);
      const response = await result.response;
      const text = response.text();
      console.log(text);
      document.getElementById('promptResponse').textContent = text
}



      // ...
</script>


<script>

    personalised = document.getElementById('personalised')
    newsCol = document.getElementById('news')
    media = document.getElementById('media')

    var addConfirm = document.getElementById('addConfirm')


    document.querySelector('.add').addEventListener('click', function(){
            if (addConfirm.style.top == "300px") {
              addConfirm.style.top = "1000px";
            }

            else{
              addConfirm.style.top = "300px";
            }
        })
   


    xhr = new XMLHttpRequest()

    xhr.open('POST','http://api.weatherapi.com/v1/current.json?key=b4928e2c394646b087365304243005&q=India&aqi=no', true)

    xhr.onload = function() {
        if (this.status = 200) {
            wInfo = JSON.parse(this.responseText)
            console.table(JSON.parse(this.responseText))

            weather = {}

            weather.weatherCondition = wInfo.current.condition.text
            weather.Humidity = wInfo.current.humidity
            weather.temp = wInfo.current.temp_c
            weather.wind = wInfo.current.wind_kph
            weather.location = wInfo.location.name +", "+wInfo.location.country


            console.table(weather)

            setWeather(weather)

        }
    }

    xhr.send()

    function setWeather(weatherObject){
        document.querySelector('.temp').textContent = weatherObject.temp
        document.querySelector('.loc').textContent = weatherObject.location
        document.getElementById('wind').textContent ="wind "+ weatherObject.wind+' kmph'
        document.getElementById('humidity').textContent = "humidity "+ weatherObject.Humidity
    }


    xml = new XMLHttpRequest()

    xml.open('GET','https://newsapi.org/v2/everything?q=keyword&apiKey=ce5a384023a94979a8ed8a62f5fadb71', true)

    xml.onload = function() {
        if (this.status === 200) {

            //get news
            // console.log(JSON.parse(this.responseText))

            news = JSON.parse(this.responseText)

            renderNews(news, 0, 10)
        }
    }

    xml.send()



    function renderNews(news, i ,j) {
//         <div class="newscard">
//   <div class="newscard-image" style="background-image: url('images/original.avif');"></div>
//   <div class="newscard-content">
//     <h2 class="newscard-title">Article Title</h2>
//     <p>This is a news card</p>
//   </div>
// </div>

      if (i<0) {
          i = 0;
          j = 10
      }

        html = ' '

        for (let index = i; index < j; index++) {
            const element = news.articles[index];
            
            html += `<div class="newscard" onclick = "window.location.href = '${element.url}' ">
            <div class="newscard-image" style="background-image: url('${element.urlToImage}');"></div>
            <div class="newscard-content">
              <h2 class="newscard-title">${element.title}</h2>
            </div>
          </div>
          `
        }

        html+=`<button onclick ='renderNews(news,${i-10} ,${j-10})' class = "scrollNews"> Back</button> `
        html+=`<button onclick ='renderNews(news,${i+10} ,${j+10})' class = "scrollNews"> Next</button> `
        newsCol.innerHTML = html
    }


    document.getElementById('contribute').addEventListener('click', function() {
        typeOfC = document.querySelector('input[name = "radio"]:checked').value
        console.log(typeOfC)


        window.location.href = 'add.php?type='+typeOfC
    })

    xml1 = new XMLHttpRequest()

    xml1.open('POST','processing.php', true)

    xml1.onload = function() {
        if (this.status === 200) {

            //get news
            // console.log(JSON.parse(this.responseText))

            console.table(JSON.parse(this.responseText)); 
            mediaObj = JSON.parse(this.responseText)
            renderMedia(mediaObj)
            
        }
    }

    var mediaCall = {}
    mediaCall.rtype =  'getMedia'

    xml1.send(JSON.stringify(mediaCall))
    
    function renderMedia(mediaObj){

      html = ' '

      mediaObj.slice().reverse().forEach(element => {
        if (element.type === 'movie') {

          html += `<div class="mediaCard">
                <div class="mediaCard-image" style="background-image: url('images/${element.image}');"></div>
                <div class="newscard-content">
                  <h2 class="newscard-title">Movie - ${element.title}</h2>
                </div>
              </div>
              `    
        }


        else if (element.type === 'song') {
          html+= `<div class="songCard" onclick="window.location.href = '${element.url}'">
        <img src="images/${element.image}" alt="pp" id="songPic">

        <div style="display: flex; flex-direction:column">
        <p>Song - ${element.title}</p>

        <label class="container1">
        <input type="checkbox">
          <svg viewBox="0 0 384 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="play"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"></path></svg>
          <svg viewBox="0 0 320 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="pause"><path d="M48 64C21.5 64 0 85.5 0 112V400c0 26.5 21.5 48 48 48H80c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zm192 0c-26.5 0-48 21.5-48 48V400c0 26.5 21.5 48 48 48h32c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H240z"></path></svg></label>

        </div>
      </div>`
        }
      });

     media.innerHTML = html

    }


    const data = null;

xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener('readystatechange', function () {
	if (this.readyState === this.DONE) {
		// console.log(this.responseText);
    gamesList = JSON.parse(this.responseText)
    console.log(gamesList)


    renderGames(gamesList)
	}
});

  xhr.open('GET', 'https://free-to-play-games-database.p.rapidapi.com/api/filter?tag=3d.mmorpg.fantasy.pvp&platform=pc');
  xhr.setRequestHeader('x-rapidapi-key', '290d4b190dmsh3dc1de8fbb81ebep18dafejsn4966092d19b3');
  xhr.setRequestHeader('x-rapidapi-host', 'free-to-play-games-database.p.rapidapi.com');
  xhr.send(data);

function renderGames(gamesList){

    html = ' '

    for (let i = 0; i < 10; i++) {
      const element = gamesList[i];
      console.log(element)

      html += `  
      
      <div style="justify-content: center;" onclick ="window.location.href='${element.game_url}'">
        <img src="${element.thumbnail}" alt="game" class="gameIcons">
        <p style="margin: 10px; max-width: 45px; overflow: hidden">${element.title}</p>
      </div>`

      
    }

    document.getElementById('gamebox').innerHTML = html
}

</script>

