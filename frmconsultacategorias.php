<?

//INICIO DE SESSION DE USUARIO
session_start();

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

// RESCATE DE VARIABLES DEL FORMULARIO
$BtnAccion=$_REQUEST['BtnAccion'];
$TxtCategoria=$_REQUEST['TxtCategoria'];


//VARIABLES DEL FORMULARIO
$Sistema="Control de Finanzas";
$FrmNombre="ConsultaCategoria";
$FrmDescripcion="Consulta de Categoria";
$TbNombre="tbcategoria";


// DESARROLLAR LOGICA DE LOS BOTONES

//switch($BtnAccion){
//case 'Limpiar':
//break;}

if ($BtnAccion=='Limpiar'){
   $TxtCategoria='';
}
   

//FUNCIONES
//FUNCION QUE CONSTRUYE LA CONSULTA
function Query($TbNombre,$TxtCategoria){

  if($TxtCategoria == ''){
     $sql="SELECT * FROM $TbNombre ORDER BY $TbNombre.catdes ASC;";
     } else {
     $sql="SELECT * FROM $TbNombre WHERE $TbNombre.catdes LIKE '%$TxtCategoria%' ORDER BY catdes ASC;";
     }
  // 4 EJECUTA LA CONSULTA
  global $resultado;
  $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
  return $resultado;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title><?echo $FrmDescripcion?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<link rel="stylesheet" type="text/css" href="css/consulta.css" />
</head>

<body <!--bgcolor="#FFFFFF"-->

<form action="<? $PHP_SELF ?>" name="<?echo $FrmDescripcion?>" method="post">
  <fieldset>
    <div align=center><h2><?echo $FrmDescripcion?></h2></div>
    <!--legend> <?echo $FrmDescripcion?> </legend-->
      <table>
        <tr>
          <div align=center>
               <input type="submit" name="BtnAccion" value="Buscar"/>
               <input type="submit" name="BtnAccion" value="Limpiar" />
          </div>
        </tr>
        <hr />
        <tr>
          <th>#</th>
          <th>Id</th>
          <th><input type='text' size='100' maxlength='100' name='TxtEnte' value="<? echo $TxtCategoria ?>"></th>
          <th><input type='text' size='100' maxlength='100' name='TxtEnte' value="<? echo $TxtCategoria ?>"></th>
        </tr>

        <?

        Query($TbNombre,$TxtCategoria);

       // 5 RECORRE EL RESULTADO
        $registro=mysql_fetch_array($resultado);
        if(mysql_num_rows($resultado)>0){
          $i=0;
          do{
            $i=$i+1;?>
            <tr>
            <td><?echo $i?></td>
            <td><?echo $registro[catid] ?></td>
            <td><?echo $registro[catdes] ?></td>
            <td><? if ($registro[cattip]=='-'){ echo 'EGRESO'; }else{echo 'INGRESO';} ?></td>
            <tr>
          <?}while($registro=mysql_fetch_array($resultado));
            } else {?>
           <script>alert ("No existen registros en la Base de Datos!!!");</script>
         <?}?>
</table>



</body>
</html>


