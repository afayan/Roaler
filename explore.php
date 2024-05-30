<?php
include_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="roaler.css">
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
    <span class="date">March 13</span>
    <span id="humidity">Loading</span>
    <span id="wind">Loading</span>
  </div>

  <span class="temp">..°</span>

  <div class="temp-scale">
    <span>Celcius</span>
  </div>



</div>

</div>


<div id="news">

<h1>Loading...</h1>



</div>
<div id="media"></div>
</body>
</html>

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

      mediaObj.forEach(element => {
        if (element.type === 'movie') {

          html += `<div class="mediaCard">
                <div class="mediaCard-image" style="background-image: url('images/${element.image}');"></div>
                <div class="newscard-content">
                  <h2 class="newscard-title">${element.title}</h2>
                </div>
              </div>
              `
          
        }
      });

     media.innerHTML = html

    }

    
</script>