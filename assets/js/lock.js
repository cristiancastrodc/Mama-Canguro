/* Script para bloquear la pantalla luego de un tiempo determinado
Autor: Cristian Castro Del Carpio -- facebook.com/xtiancastro7
Fecha: 08-05-2015 */

var counter = 0;

function incrementar () {
  counter++;
  if (counter == 120) {
    location.href = "../lock_screen.php";
  };
}

var myVar = setInterval(function(){ incrementar() }, 1000);

$(document).mousemove(function(){
  counter = 0;
});
