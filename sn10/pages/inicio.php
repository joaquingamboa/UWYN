<?php
if (isset($_SESSION['user_id'])){
require_once('class/users.php');
require_once('class/news.php');
require_once('class/pages.php');
$usuario = new User($_SESSION['user_id'], null, null, null, null, null, null, null, null);
$usuario->obtenerDatosIndex();
$per_page = 10; 
$news = new News(null, null, null, null, null, null, null, null, null, null, null, null, null);
$paged = $news->obtenerPaginacionPropia($per_page);
$pageg = new Pages(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
$paged2 = $pageg->obtenerTodasParaPaginacionPropias($per_page);
?>
<div id="column">

<div id="left_content">
    <h2 style="text-align:center;">Mis Datos</h2>
    <table class="lst" style="margin: 0 auto;color:black;font-size:12px;" >
        <tr>
            <td style="text-align:right;">Username:</td>
            <td style="text-align:left;"><?php echo $usuario->getUsername();?></td>
        </tr>
        <tr>
            <td style="text-align:right;">Nickname:</td>
            <td style="text-align:left;"><?php echo $usuario->getNickname();?></td>
        </tr>
        <tr>
            <td style="text-align:right;">FECHA - HORA REGISTRO:</td>
            <td style="text-align:left;"><?php echo $usuario->getRegistertime();?></td>
        </tr>
    </table>  
  
    
    
</div>


<div id="right_content">
<h2>Contenido</h2>
<p>Este es el contenido creado por ti:</p>
<div id="loading" ></div>

<div id="contenttNoticiasPropias" class="sizeEleven"></div>
     <ul id="PNoticiasPropias">
				<?php
				//Show page links
				for($i=1; $i<=$paged2; $i++){
					echo '<li class="sizeEleven" id="'.$i.'">'.$i.'</li>';
                                                            }
				?>
	</ul>	
<br style="clear:both;" />
<div id="loading1" ></div>
 
<div id="contenttPaginasPropias" class="sizeEleven" ></div>
   
     <ul id="paginationPaginasPropias">
				<?php
				//Show page links
				for($i=1; $i<=$paged; $i++){
					echo '<li class="sizeEleven" id="'.$i.'">'.$i.'</li>';
                                                            }
				?>
	</ul>	          
    
</div>
</div>

<?php
}
?>