<?php
$menu = ("---------------\n1) Iniciar servidor\n2) Abrir chrome en http://localhost:3000\n3) Abrir VSCode\n4) Abrir carpeta\n5) Abrir línea de comandos\n6) Abrir php.ini\n0) Salir\n");
print $menu;
$r = readline("Elegí una opción: ");
while( $r != 0 ):
  if( $r == 1 ) pclose(popen("cmd /c start c:\\xampp\\php\\php.exe -S 0.0.0.0:3000 -t publica/","r"));
  if( $r == 1 ) exec("start chrome http://localhost:3000/");
  else if( $r == 2 ) exec("start chrome http://localhost:3000/");
  else if( $r == 3 ) exec("start code .");
  else if( $r == 4 ) exec("start explorer .");
  else if( $r == 5 ) exec("start cmd /k cd .");
  else if( $r == 6 ) exec("start notepad c:\\xampp\\php\\php.ini");
  else print("Opción no válida\n");
  print $menu ;
  $r = readline("Elegí una opción: ");
endwhile;
