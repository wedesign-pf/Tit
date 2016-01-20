<?php
include_once('include/webzone.php');

if(!is_admin()) header('Location: ./');
$jsOnReady = '$("#status").focus();';

$page_number = $_GET['page'];
$type = $_GET['type'];

if($page_number=='') $page_number=1;
$nb_display=5;
$start = ($nb_display*$page_number)-$nb_display;

include_once('include/presentation/header.php');
?>

<div class="container">	
	<div class="row">
		
		<div class="span12">
			
			<b>History</b> (<a href="home.php">Back to home</a>)</p>
			
			<form style="margin-bottom:0px;">
				<input type="hidden" name="page" value="1">
				<select name="type" onchange="form.submit();">
				<option value="">All</option>
				<?php
				$tab = array('1'=>'Facebook', '2'=>'Twitter');
				foreach($tab as $ind=>$value) {
					if($ind==$type) echo '<option selected value="'.$ind.'">'.$value.'</option>';
					else echo '<option value="'.$ind.'">'.$value.'</option>';
				}
				?>
				</select>
			</form>
			
			<table class="table">
			<thead>
			<tr>
				<th>Name</th>
				<th>Results</th>
				<th>Date</th>
			</tr>
			</thead>
			
			<tbody>
			<?php
			$history = getHistory(array('type'=>$type, 'start'=>$start, 'nb_display'=>$nb_display));
			$tmpCSS='';
			$tmpCreated='';
			
			for($i=0; $i<count($history); $i++) {
				
				if($tmpCreated!=$history[$i]['created']) {
					if($tmpCSS=='') $tmpCSS = 'grey_row';
					else $tmpCSS = '';
				}
				
				echo '<tr class="'.$tmpCSS.'">';
				echo '<td>';
				if($history[$i]['type']==1) echo '<img src="include/graph/icons/facebook16.png"> ';
				else echo '<img src="include/graph/icons/twitter16.png"> ';
				echo $history[$i]['name'];
				echo '</td>';
				
				if($history[$i]['message_id']!='') {
					echo '<td>';
					if($history[$i]['type']==1) echo '<a href="https://www.facebook.com/'.$history[$i]['message_id'].'" target="_blank">'.$history[$i]['message_id'].'</a>';
					else echo '<a href="http://twitter.com/'.$history[$i]['name'].'/status/'.$history[$i]['message_id'].'" target="_blank">'.$history[$i]['message_id'].'</a>';
					echo '</td>';
				}
				else {
					echo '<td><font color="red">Error: </font>'.$history[$i]['result'].'</td>';
				}
				
				echo '<td>'.$history[$i]['created'].'</td>';
				echo '</tr>';
				
				$tmpCreated = $history[$i]['created'];
			}
			
			?>
			</tbody>
			</table>
			
			<?php
			$history = getHistory(array('type'=>$type));
			echo '<center>'.display_pagination(array('start'=>$start, 'nb_display'=>$nb_display, 'nbTotal'=>count($history))).'</center>';
			?>
			
		</div>
		
	</div>
</div>

<?php
include_once('include/presentation/footer.php');
?>