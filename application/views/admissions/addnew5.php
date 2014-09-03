<section id="content">

<?php
	if(isset($error))
	{
		echo "<div id=\"error\" style=\" display: block; \">{$error}</div>";

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
	echo heading('Step 5 - Father\'s Details', 3);
	
	$output = $this->session->userdata('sess');
	echo "<h4>You Admission Number is\t".$output['adm']."<p></h4>";
	
	$array = array( 'id' => 'step5');
	echo form_open('admissions/addnew', $array);
	echo form_hidden('actionflag', 'step5');

	echo form_label('First Name:', 'f_name');
	
	$attrib1 = array( 'name' => 'f_name',
					  'id' => 'f_name',
					  'size' => '20'
					  );
	echo form_input($attrib1);
	echo "<p>";
	echo form_label('Last Name:', 'l_name');
	
	$attrib2 = array( 'name' => 'l_name',
					  'id' => 'l_name',
					  'size' => '20'
					  );
	echo form_input($attrib2);
	echo "<p>";
	echo form_label('Postal Address:', 'pa');
	
	$attrib3 = array( 'name' => 'paddress',
					  'id' => 'paddress',
					  'size' => '20'
					);
	echo form_input($attrib3);
	echo "<p>";
	echo form_label('Postal Code:', 'pcode');
	
	$attrib4 = array( 'name' => 'pcode',
					  'id' => 'pcode',
					  'size' => '20'
					  );
	echo form_input($attrib4);
	echo "<p>";
	echo form_label('Phone Number:', 'phone');
	
	$attrib5 = array( 'name' => 'phone',
					  'id' => 'phone',
					  'size' => '20'
					  );
	echo form_input($attrib5);
	echo "<p>";
	echo form_label('Email Address', 'email');
	
	$attrib6 = array( 'name' => 'email',
					  'id' => 'email',
					  'size' => '20'
					  );
	echo form_input($attrib6);
	echo "<p>";
	echo form_submit( 'submit', 'Save and Proceed');
	
	echo form_close();
	
?>

</div>
</section>