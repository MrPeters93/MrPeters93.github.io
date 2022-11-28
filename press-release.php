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
        <a target="_blank" href ="https://github.com/MrPeters93/MrPeters93.github.io">
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
      <div>
      Regulatory?
      <select id="FilterType" value="" style="margin-right:0px;">
        <option value="">All</option>
        <option value=":regulatory">Yes</option>
        <option value="sub:ci">No</option>
      </select>
    </div>
<div>
  Year:
      <select id="FilterYear" value="" style="margin-right:0px;">
        <option value="">Every year</option>
        <?php
        for($i = date("Y"); $i> 2000; $i--){
          echo "<option>".$i."</option>";
        }
        ?>
      </select>
    </div>
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
  <!-- curl -->
  <?php

  $curl = curl_init();

  curl_setopt($curl, CURLOPT_URL,
  "https://feed.mfn.se/v1/feed/7c0dc3f4-0d57-4bea-ba07-94a9ff1f543f.json");

  curl_setopt($curl,
  CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($curl);

  if($e = curl_error($curl)) {
    echo $e;
  } else {

    $decodedData =
    json_decode($response, true);


    ?>
    <div id="articles">
      <?php foreach ($decodedData["items"] as $key => $value): ?>

        <?php echo "<div name='article' class='article' id=".$value['news_id'].">";?>
        <?php $date= date_create($value["content"]["publish_date"]);
        $date2= date_format($date, "Y/m/d H:i");?>
        <?php echo "<div name='regulatory' style='visibility:hidden;' id = 'regulatory'>".$value['properties']['tags']['0']."</div>"?>
        <?php echo "<div name='regulatory' style='visibility:hidden;' id = 'year'>".date_format($date, "Y")."</div>"?>

          <div class ="a_date"><?php echo $date2;?><br></div>
          <?php echo "<a target='_blank' href=".$value["content"]["attachments"][0]["url"].">"?>
            <div class="a_title"><?php echo $value["content"]["title"];?> <br></div>
            <div class="a_url">Read more</a></div>

          </div>
        <?php endforeach; ?>
      </div>


      <?php
    }

    curl_close($curl);
    ?>

  </div>

<!-- JS -->
  <script src="jquery-3.3.1.min.js"></script>

  <script>

  function updateList(){
    var table, art, td, i, txtValue;
    var regCheck = document.getElementById("FilterType").value;

    var yearCheck = document.getElementById("FilterYear").value;

    table = document.getElementById("articles");
    art = table.getElementsByClassName("article");


    for (i = 0; i < art.length; i++) {
      td0 = art[i].children[0].textContent;
      td1 = art[i].children[1].textContent;

      if (td0) {

      if (td0.indexOf(regCheck) > -1 && td1.indexOf(yearCheck) > -1)
      {
        art[i].style.display = "flex";
      }

      else
      {
        art[i].style.display = "none";
      }
  }
}
}

</script>

</body>
</html>
