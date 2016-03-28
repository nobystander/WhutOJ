$(document).ready(function(){
    var Data = [
         {
             label: "CE",
             value: parseInt($("#statistics .data #CE_num span").text()),
             color:"#F7464A"
         },
         {
             label: "AC",
             value : parseInt($("#statistics .data #AC_num span").text()),
             color : "#46BFBD"
         },
         {
             label: "RE",
             value : parseInt($("#statistics .data #RE_num span").text()),
             color : "#FDB45C"
         },
         {
             label: "WA",
             value : parseInt($("#statistics .data #WA_num span").text()),
             color : "#949FB1"
         },
         {
             label: "Other",
             value : parseInt($("#statistics .data #Other_num span").text()),
             color : "#4D5360"
         }
    ];
    var myDoughnut = new Chart(document.getElementById("canvas").getContext("2d")).Doughnut(Data);
});