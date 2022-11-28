<?php
session_start();
ini_set("allow_url_fopen", 1);
?>

<html>
<head>
  <meta charset=utf-8>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body class="BodyPress">

  <!-- Navigeringsmeny -->
  <div class="NavBar">
    <div class="Big">
      <div id="Github_link" title="Github">
        <a href ="https://github.com/MrPeters93/MrPeters93.github.io">
          Github
          <span class="material-symbols-outlined">
            home_storage
          </span>
        </a>
      </div>
    </div>
  </div>

  <!-- Greetings! -->

  <h1 id ="Greetings">Greetings </h1>


  <!-- Filter -->
  <div class="FilterBar">
    <div class="Filter" style="align-self:center">
      Select type
      <select id="FilterType" onselect="updateList()">
        <option><a href="?Regulatory">1</a></option>
        <option value="Man">2</option>
        <option value="Kvinna">3</option>
        <option value="Annan">4</option>
      </select>
    </div>

    <!-- Filtrera på frågor -->
    <div style="align-self:center;">
      <button onclick="updateList()">Filter</button>
      <div class="content">

      </div>
    </div>
  </div>

</div>
<div id="releases">
  <?php

  // Initializing curl
  $curl = curl_init();

  // Sending GET request to reqres.in
  // server to get JSON data
  curl_setopt($curl, CURLOPT_URL,
  "https://feed.mfn.se/v1/feed/7c0dc3f4-0d57-4bea-ba07-94a9ff1f543f.json");

  // Telling curl to store JSON
  // data in a variable instead
  // of dumping on screen
  curl_setopt($curl,
  CURLOPT_RETURNTRANSFER, true);

  // Executing curl
  $response = curl_exec($curl);

  // Checking if any error occurs
  // during request or not
  if($e = curl_error($curl)) {
    echo $e;
  } else {

    // Decoding JSON data
    $decodedData =
    json_decode($response, true);

    // Outputting JSON data in
    // Decoded form

    //if (!($_GET['regulatory'])){}

    ?>
    <div id="articles">
          <?php foreach ($decodedData["items"] as $key => $value): ?>
            <div class="article">

              <?php $date= date_create($value["content"]["publish_date"]);
              $date2= date_format($date, "Y/m/d H:i");

              ?>
              <div class ="a_date"><?php echo $date2;?><br></div>
              <?php echo "<a href=".$value["content"]["attachments"][0]["url"].">"?>
            <div class="a_title"><?php echo $value["content"]["title"];?> <br></div>
            <div class="a_url">Read more</a></div>
          </div>
          <?php endforeach; ?>
      </div>


    <?php
  }

  // Closing curl
  curl_close($curl);
  ?>

</div>

<!-- Hämtning av jquery för användande inom javascript -->
<script src="jquery-3.3.1.min.js"></script>

<!-- Påbörjan av javascript -->
<script>

function updateList(){
}

</script>

</body>
</html>
