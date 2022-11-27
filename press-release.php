<? php
session_start();
?>

 <html>
 <head>
 <meta charset=utf-8>
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body class="BodyPress">

<!-- Navigeringsmeny -->
<div id="NavBar">
<div class="Big">
<div id="home" title="Github">
  <a href ="https://github.com/MrPeters93/MrPeters93.github.io">
    <i class="material-icons">
      hub
    </i>
  </a>
</div>
</div>
</div>

<!-- Filter -->
<div id="FilterBar">
  <div class="Filter">
    Select type
    <select id="FilterType">
      <option value=""></option>
      <option value="Man">Man</option>
      <option value="Kvinna">Kvinna</option>
      <option value="Annan">Annan</option>
    </select>
  </div>

  <!-- Filtrering på ålder -->
  <span class="Filter">
    Filtrera efter ålder:
    Mellan
    <input class="AgeInput" value="1" type="number" placeholder="Minimum" id="FilterMin" min="1">
    och
    <input class="AgeInput" value="99" type="number" placeholder="Maximum" id="FilterMax" min="30" max="99">
    år
  </span>

  <!-- Filtrera på frågor -->
  <div>
    <button class="collapsible">Filtrera inom frågor</button>
    <div class="content">
      <?php

      echo '<div>';
      echo '<select id="SelectEnkat">'; // onchange="SelectEnkatChange()"
      echo '<option value="Alla">Alla</option>';
      foreach($pdo->query( 'SELECT DISTINCT * FROM ENKAT' ) as $SelectEnkat){
        if (mb_detect_encoding($SelectEnkat["NAMN"], 'utf-8', true) === false) {
          $SelectEnkat["NAMN"] = mb_convert_encoding($SelectEnkat["NAMN"], 'utf-8', 'iso-8859-1');
        }

        if (mb_detect_encoding($SelectEnkat['BESKRIVNING'], 'utf-8', true) === false) {
          $SelectEnkat['BESKRIVNING'] = mb_convert_encoding($SelectEnkat['BESKRIVNING'], 'utf-8', 'iso-8859-1');
        }

        echo '<option name="EnkatSelect" value='.$SelectEnkat["NAMN"].'>'.$SelectEnkat['NAMN'].': '.$SelectEnkat['BESKRIVNING'].'</option>';
      }
      echo '</select>';
      echo '</div>';

      echo '<div id="FragaHide">';

          //
          foreach ($pdo->query('SELECT DISTINCT ENKATNAMN FROM ENKATFRAGA') as $QueryEnkatNamn){

             $EnkatNamn = $QueryEnkatNamn['ENKATNAMN'];

             if (mb_detect_encoding($EnkatNamn, 'utf-8', true) === false) {
               $EnkatNamn = mb_convert_encoding($EnkatNamn, 'utf-8', 'iso-8859-1');
             }

             echo '<div id='.$EnkatNamn.' class="Hide '.$EnkatNamn.'">';
             echo 'Enkat: '.$EnkatNamn;

             foreach($pdo->query('SELECT * FROM FRAGA, ENKATFRAGA WHERE FRAGA.FID=ENKATFRAGA.FID AND ENKATFRAGA.ENKATNAMN="'.$EnkatNamn.'";') as $SelectFraga){ //

               if (mb_detect_encoding($SelectFraga['INNEHALL'], 'utf-8', true) === false) {
                 $SelectFraga['INNEHALL'] = mb_convert_encoding($SelectFraga['INNEHALL'], 'utf-8', 'iso-8859-1');
               }

               echo '<div>';
               echo '<input name="FCheckbox" class="FCheckbox" type="checkbox" value='.$SelectFraga["FID"].'>'.$SelectFraga['FID'].': '.$SelectFraga['INNEHALL'];
               echo '</div>';
             }
            echo '</div>';
          }

      echo '</div>';
      ?>
    </div>
</div>
</div>

<!-- Hämtning av jquery för användande inom javascript -->
<script src="jquery-3.3.1.min.js"></script>
<!-- Påbörjan av javascript -->
<script>

// Filtrering


function Filtrera(){
  // Deklarering av variabler
  var table, tr, td, i, txtValue;
  var inputDeltagare1, inputDeltagare1, filterDeltagare;
  var inputType, filterType;
  var inputMin, inputMax, filterMin, filterMax;
  var inputFraga;
  var inputSvar, filterSvar;
  var inputTid, filterTid;
  var inputKommun, filterKommun;
  var inputCheckbox, filterCheckbox;
  var inputKategori, filterKategori;

// Tilldelande av värden till variabler
// Deltagare
  inputDeltagare = document.getElementById("FilterDeltagare");

  filterDeltagare = inputDeltagare.value.toUpperCase();


// Type
  inputType = document.getElementById("FilterType");
  filterType = inputType.value.toUpperCase();
// Ålder
  inputMin = document.getElementById("FilterMin");
  inputMax = document.getElementById("FilterMax");

  filterMin = inputMin.value.toUpperCase();
  filterMax = inputMax.value.toUpperCase();
// Fråga
  inputFraga = document.getElementsByTagName("fCheckbox");
// Kommun
  inputKommun = document.getElementById("FilterKommun");
  filterKommun = inputKommun.value.toUpperCase();
// Svar
  inputKommentar = document.getElementById("FilterKommentar");
  filterKommentar = inputKommentar.value.toUpperCase();
// Tabell
  table = document.getElementById("TabellBody");
  tr = table.getElementsByTagName("tr");
//Kategori
  inputKategori = document.getElementById("filterKategori");
  filterKategori= inputKategori.value.toUpperCase();

// Hämta checkbox och för in det i en array
var filterFraga = new Array();
var filterFraga = $("input:checkbox[class=FCheckbox]:checked").map(function(){return $(this).val()}).get()

console.log(filterFraga);
console.log(filterDeltagare)

// Gammal kontroll av innehåll. Stannar kvar som referens.
//   if(document.getElementById('FilterKön').value == "Alla") {
//     filterKon='';
// }

  // Itererar genom tabellens rader
  for (i = 0; i < tr.length; i++) {
    // Tilldelar respektive array-cell till variabler
    td0 = tr[i].getElementsByTagName("td")[0]; // Deltagare
    td1 = tr[i].getElementsByTagName("td")[1]; // Kön
    td2 = tr[i].getElementsByTagName("td")[2]; // Ålder
    td3 = tr[i].getElementsByTagName("td")[3]; // Fråga
    td4 = tr[i].getElementsByTagName("td")[4]; // Svar
    td5 = tr[i].getElementsByTagName("td")[5]; // Tid
    td6 = tr[i].getElementsByTagName("td")[6]; // WorkshopID - Hidden
    td7 = tr[i].getElementsByTagName("td")[7]; // Kommun
    td8 = tr[i].getElementsByTagName("td")[8]; // kommentar
    td9 = tr[i].getElementsByTagName("td")[9]; // Kategori




    // Om den itererar över respektive cell
    if (td0) {
      // Tilldelande av cellernas värde till variabler

      txtValue0 = td0.textContent || td0.innerText;
      txtValue1 = td1.textContent || td1.innerText;
      txtValue2 = td2.textContent || td2.innerText;
      txtValue3 = td3.textContent || td3.innerText;
      txtValue4 = td4.textContent || td4.innerText;
      txtValue5 = td5.textContent || td5.innerText;
      txtValue6 = td6.textContent || td6.innerText;
      txtValue7 = td7.textContent || td7.innerText;
      txtValue8 = td8.textContent || td8.innerText;
      txtValue9 = td9.textContent || td9.innerText;

      console.log(txtValue9);

      var FragaFilterNum = filterFraga.map(Number);
      var txtValue3Num = parseInt(txtValue3, 10);
      var FragaFilterBool;

      if (FragaFilterNum.includes(txtValue3Num) == true || FragaFilterNum.length == 0){
        FragaFilterBool=1;
      }

      else {
        FragaFilterBool=0;
      }

      // Om båda cellerna matchar de önskade värdena
      if (txtValue0.toUpperCase().indexOf(filterDeltagare) > -1 && txtValue1.toUpperCase().indexOf(filterType) > -1 && txtValue2 <= filterMax && txtValue2 >= filterMin && FragaFilterBool==1 && txtValue4.toUpperCase().indexOf(filterKommentar) > -1 &&  txtValue6.toUpperCase().indexOf(filterKommun) > -1 && txtValue9.toUpperCase().indexOf(filterKategori) > -1 )
    {
        // Display ändras inte
        tr[i].style.display = "";
      }

      else
      {
        // Raden göms
        tr[i].style.display = "none";
      }
    }
  }
}

// $(document).ready(function(){
//         $('input[type="checkbox"]').click(function(){
//             if($(this).is(":checked")){
//                 alert("Checkbox is checked.");
//             }
//             else if($(this).is(":not(:checked)")){
//                 alert("Checkbox is unchecked.");
//             }
//         });
//     });


//Collapsible för filtrering av frågor
var coll = document.getElementsByClassName("collapsible");
var c;

for (c = 0; c < coll.length; c++) {
  coll[c].addEventListener("click", function() { //Funktionaliteten att vänta på klickandet för variabeln coll läggs till
    this.classList.toggle("active");



    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
      $('.FilterBar').css('width','40%');
    } else {
      content.style.display = "block";
      $('.FilterBar').css('width','75%');
    }
  });
}

$("#SelectEnkat").change(function () {
    // hide all optional elements
    $('.Hide').css('display','none');

    var SelectEnkat = document.getElementById("SelectEnkat");
    var EnkatFragor = document.getElementById("FragaHide");

    $('#FragaHide').css('display','block');

    console.log(EnkatFragor);

    FilterFraga = SelectEnkat.value;

    console.log(SelectEnkat);
    console.log(FilterFraga);

    $("select option:selected").each(function () {
        if($(this).val() == 'INFOR') {
            $('.INFOR').css('display','block');
        } else if($(this).val() == "UTVARDERING") {
            $('.UTVARDERING').css('display','block');
        }

    });
});

window.onload = Filtrera();

</script>

</body>
</html>
