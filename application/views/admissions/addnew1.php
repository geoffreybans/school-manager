<section id="content">

<?php
	if(isset($error))
	{
		echo "<div id=\"error\" style=\" display: block; \">{$error}.</div>";

	}
	
	if(isset($success))
	{
		echo "<div id=\"success\" style=\" display: block; \">{$success}</div>";
	
	}


?>

<div id="main">
<?php 
	
	echo "<img src=\"".base_url()."images/admission.png\" /><p>";
	echo "<img src=\"".base_url()."images/underline.jpg\" /><p>";

	
	echo heading('Admission', 2);
	echo heading('Step 1- Basic Details', 3);
	
	$array = array( 'id' => 'step1');
	echo form_open('admissions/addnew', $array);
	
	echo form_hidden('actionflag', 'step1', 'id="actionflag"');
	
	echo form_label('Admission Number', 'adm');
	
	$attrib1 = array( 'name' => 'adm',
					  'id' => 'adm',
					  'size' => '20'
					 );
					 
	echo form_input($attrib1);
	echo "<p>";
	echo form_label('First Name:', 'f_name');
	
	$attrib2 = array( 'name' => 'f_name',
					  'id' => 'f_name',
					  'size' => '20'
					  );
					  
	echo form_input($attrib2);
	echo "<p>";
	echo form_label('Middle Name:', 'm_name');
	
	$attrib3 = array( 'name' => 'm_name',
					  'id' => 'm_name',
					  'size' => '20'
					  );
					  
	echo form_input($attrib3);
	echo "<p>";
	echo form_label('Last Name:', 'l_name');
	
	$attrib4 = array( 'name' => 'l_name',
					  'id' => 'l_name',
					  'size' => '20'
					  );
					  
	echo form_input($attrib4);
	echo "<p>";
	echo form_submit('submit', 'Save and Proceed');
	echo form_close();

	
	?>
	
</div>
</section>