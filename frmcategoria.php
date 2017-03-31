<?
//INICIO DE SESSION DE USUARIO
session_start();

//SEGURIDAD DE ACCESO
//require_once("seguridad.php");

//1. CONECTAR CON MYSQL
//2. CONECTAR CON BD
require_once("conexion.php");

$Sistema="Control de Finanzas";
$FrmNombre="Categoria";
$FrmDescripcion="Maestro de Categoria";
$TbNombre="tbcategoria";



//DESARROLLAR LA LOGICA DE LOS BOTONES
$TxtId=$_REQUEST['TxtId'];
$TxtDescripcion=$_REQUEST['TxtDescripcion'];
$CmbTipo=$_REQUEST['CmbTipo'];
$BtnAccion=$_REQUEST['BtnAccion'];

switch($BtnAccion){

case 'Buscar':
     //3. Contruir la consulta (Query)
     $sql="SELECT * FROM $TbNombre WHERE catid='$TxtId';";
     //4. Ejecutar la consulta
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     // 5. verificar si lo encontro
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)>0){
         //6. recuperar registros
         $TxtId=$registro['catid'];
         $TxtDescripcion=$registro['catdes'];
         $CmbTipo=$registro['cattip'];
         } else {
         ?><script>alert ("<?echo $FrmNombre?> No encontrada!!!");</script><?
         $BtnAccion='Limpiar';}
break;

case 'Modificar':
     //3. Contruir la consulta (Query)
     $sql="UPDATE $TbNombre SET `cattip`='$CmbTipo',
                                `catdes`='$TxtDescripcion' WHERE gacid='$TxtId'";

     //4. Ejecutar la consulta
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     ?>
     <script>alert ("Los datos de <? echo $FrmNombre;?> fueron modificado con éxito!!!")</script>
     <?
break;


case 'Agregar':
     $sql="SELECT * FROM $TbNombre WHERE catid='$TxtId';";
     $resultado = mysql_query($sql) or die( "Error en $sql: " . mysql_error() );
     $registro=mysql_fetch_array($resultado);
     if(mysql_num_rows($resultado)==0){
     $sql="INSERT INTO $TbNombre VALUES('$TxtId','$TxtDescripcion','$CmbTipo');";
     mysql_query($sql);
     ?>
       <script>alert ("Los datos de <? echo $FrmNombre;?> fueron registrados con éxito!!!");</script>
     <?
     $BtnAccion='Limpiar';
     }else{
     ?>
       <script>alert ("Esta <? echo $FrmNombre;?> ya está registrada!!!");</script>
     <?
     }
break;
}

if ($BtnAccion=='Limpiar'){
     $TxtId='';
     $CmbTipo=0;
     $TxtDescripcion='';
     unset($BtnAccion);}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
<head>
<title><?echo $Sistema?></title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<link rel="stylesheet" type="text/css" href="css/basico.css" />

<!--alert('Bienvenido '+ '<? echo $_SESSION['usuario']?>' + ' ahora puedes aportar contenido a GuiasUba!!!');-->

<script>

function validabuscar(form){

    if (form.TxtId.value== ""){
       alert('Debe introducir un Id');
       form.TxtId.focus();
       return false;}

     else {return true;}
}

function validar(form){

    if (form.TxtId.value== ""){
       alert('Debe introducir un Id');
       form.TxtId.focus();
       return false;}

       else if (form.TxtDescripcion.value== ""){
           alert('Debe introducir una Descripcion de <? echo $FrmNombre?>');
           form.TxtDescripcion.focus();
           return false;}

       else if (form.CmbTipo.value==0){
         alert('Debe introducir un Tipo de <? echo $FrmNombre?>');
         form.CmbTipo.focus();
         return false;}

     else {return true;}
}
</script>

</head>
<body bgcolor="#FFFFFF">
      <form action="<? $PHP_SELF ?>" method="post" enctype="multipart/form-data" name="form">
      <fieldset>
      <div align=center><h2><?echo $FrmDescripcion?></h2></div>

      <label>Id Categoria:</label>
      <input type='text' size='4' maxlength='4' name='TxtId' value="<? echo $TxtId ?>"><br>

            <label>Descripcion de Categoria:</label>
      <input type='text' size='100' maxlength='100' name='TxtDescripcion' value="<? echo $TxtDescripcion ?>"><br>


      <label>Tipo Categoria:</label>
      <select name= "CmbTipo" size="1"><br>
              <option value="0" >Seleccione</option>
              <option value="+" >Ingreso</option>
              <option value="-" >Egreso</option>
              <?
                if ($CmbTipo==$registro[catid]){$x='Selected'; }else{$x='';}
                      echo "<b><option value= \"$registro[catid]\" $x> $registro[tgades]</option></b>";
              ?>

       </select><br>


       <hr />

       <div align=center>
            <input type="submit" name="BtnAccion" value="Buscar" onclick="return validabuscar(this.form);" />
            <input type="submit" name="BtnAccion" value="Agregar" onclick="return validar(this.form);" />
            <input type="submit" name="BtnAccion" value="Modificar" onclick="return validar(this.form);" />
            <input type="submit" name="BtnAccion" value="Limpiar" />
      </div>

     </fieldset>
     </form>
</body>


</html>