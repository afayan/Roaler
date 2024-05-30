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
<body style="margin-left: 250px; overflow:hidden; background-color:bisque; display:flex; flex-direction:row">

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

<div class="newscard">
  <div class="newscard-image" style="background-image: url('images/original.avif');"></div>
  <div class="newscard-content">
    <h2 class="newscard-title">Article Title</h2>
    <p>This is a news card</p>
  </div>
</div>


<div class="newscard">
  <div class="newscard-image" style="background-image: url('images/original.avif');"></div>
  <div class="newscard-content">
    <h2 class="newscard-title">Article Title</h2>
    <p>This is a news card</p>
  </div>
</div>


<div class="newscard">
  <div class="newscard-image" style="background-image: url('images/original.avif');"></div>
  <div class="newscard-content">
    <h2 class="newscard-title">Article Title</h2>
    <p>This is a news card</p>
  </div>
</div>


</div>
<div id="media"></div>
</body>
</html>

<script>

    personalised = document.getElementById('personalised')
    news = document.getElementById('news')
    media = document.getElementById('media')
   


    xhr = new XMLHttpRequest()

    xhr.open('POST','http://api.weatherapi.com/v1/current.json?key=b4928e2c394646b087365304243005&q=India&aqi=no', true)

    xhr.onload = function() {
        if (this.status = 200) {
            wInfo = JSON.parse(this.responseText)
            // console.table(JSON.parse(this.responseText))

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
</script>